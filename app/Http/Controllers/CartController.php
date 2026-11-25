<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->stock <= 0) {
            return redirect('/products/' . $product->id)->with('success', '現在在庫切れのためカートに追加できません。');
        }

        $quantity = max(1, (int) $request->input('quantity', 1));
        $cart = session()->get('cart', []);
        $currentQty = $cart[$id]['quantity'] ?? 0;
        $newQty = min($product->stock, $currentQty + $quantity);

        $cart[$id] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $newQty,
        ];

        session()->put('cart', $cart);

        return redirect('/cart')->with('success', 'カートを更新しました！（最大在庫数まで調整されます）');
    }

    public function update(Request $request, $id)
    {
        $quantity = (int) $request->input('quantity', 1);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($quantity <= 0) {
                unset($cart[$id]);
                session()->put('cart', $cart);
                return redirect('/cart')->with('success', 'カートから商品を削除しました。');
            }

            $product = Product::find($id);
            if ($product) {
                $quantity = min($product->stock, $quantity);
                if ($quantity <= 0) {
                    unset($cart[$id]);
                    session()->put('cart', $cart);
                    return redirect('/cart')->with('success', '在庫切れのためカートから削除しました。');
                }
            }

            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return redirect('/cart')->with('success', '数量を更新しました！');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect('/cart')->with('success', 'カートから商品を削除しました。');
    }
}
