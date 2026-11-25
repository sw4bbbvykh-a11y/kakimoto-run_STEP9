<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class MypageController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $myProducts = Product::where('user_id', $user->id)
            ->orderBy('id', 'asc')
            ->get();

        $orders = Order::with('items')
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->get();

        return view('mypage.index', compact('user', 'myProducts', 'orders'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('mypage.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_kanji' => ['required', 'string', 'max:255'],
            'name_kana' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update([
            'name' => $validated['name'],
            'name_kanji' => $validated['name_kanji'],
            'name_kana' => $validated['name_kana'],
            'email' => $validated['email'],
        ]);

        return redirect('/mypage')->with('success', 'アカウント情報を更新しました！');
    }
}
