<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        $query = Product::query()->orderBy('id', 'asc');

        if (auth()->check()) {
            $query->where(function ($q) {
                $q->where('user_id', '!=', auth()->id())
                  ->orWhereNull('user_id');
            });
        }

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                  ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }

        if ($minPrice !== null && $minPrice !== '') {
            $query->where('price', '>=', (int) $minPrice);
        }

        if ($maxPrice !== null && $maxPrice !== '') {
            $query->where('price', '<=', (int) $maxPrice);
        }

        $products = $query->get();

        return view('products.index', compact('products', 'keyword', 'minPrice', 'maxPrice'));
    }

    public function create()
    {
        if (!auth()->check()) {
            return redirect('/login')->withErrors(['email' => '商品登録にはログインが必要です。']);
        }

        return view('products.create');
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login')->withErrors(['email' => '商品登録にはログインが必要です。']);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'image_path' => $imagePath,
            'stock' => $validated['stock'],
        ]);

        return redirect('/mypage')->with('success', '新しい商品を出品登録しました！');
    }

    public function show($id)
    {
        $product = Product::with('user')->findOrFail($id);
        $isFavorited = false;

        if (auth()->check()) {
            $isFavorited = Favorite::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->exists();
        }

        return view('products.show', compact('product', 'isFavorited'));
    }

    public function myShow($id)
    {
        if (!auth()->check()) {
            return redirect('/login')->withErrors(['email' => '出品商品詳細の確認にはログインが必要です。']);
        }

        $product = Product::with('user')->findOrFail($id);

        if ($product->user_id !== null && $product->user_id !== auth()->id()) {
            return redirect('/mypage')->withErrors(['product' => '他のユーザーの出品商品は表示できません。']);
        }

        return view('products.my-show', compact('product'));
    }

    public function toggleFavorite($id)
    {
        if (!auth()->check()) {
            return redirect('/login')->withErrors(['email' => 'お気に入り登録にはログインが必要です。']);
        }

        $product = Product::findOrFail($id);
        $existing = Favorite::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $message = 'お気に入りを解除しました。';
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ]);
            $message = 'お気に入りに登録しました！';
        }

        return redirect('/products/' . $product->id)->with('success', $message);
    }

    public function purchaseForm($id)
    {
        $product = Product::with('user')->findOrFail($id);
        return view('products.purchase', compact('product'));
    }

    public function purchase(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->stock <= 0) {
            return redirect('/products/' . $product->id . '/purchase')
                ->withErrors(['quantity' => '残り在庫が0のため購入できません。']);
        }

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:' . $product->stock],
        ]);

        $order = DB::transaction(function () use ($id, $validated) {
            $target = Product::lockForUpdate()->findOrFail($id);

            if ($target->stock < $validated['quantity']) {
                abort(422, '在庫が不足しています。');
            }

            $total = $target->price * $validated['quantity'];

            $createdOrder = Order::create([
                'user_id' => auth()->id(),
                'total_price' => $total,
                'status' => 'completed',
            ]);

            OrderItem::create([
                'order_id' => $createdOrder->id,
                'product_id' => $target->id,
                'product_name' => $target->name,
                'price' => $target->price,
                'quantity' => $validated['quantity'],
            ]);

            $target->stock -= $validated['quantity'];
            $target->save();

            return $createdOrder;
        });

        return redirect('/orders/complete/' . $order->id);
    }

    public function edit($id)
    {
        if (!auth()->check()) {
            return redirect('/login')->withErrors(['email' => '商品編集にはログインが必要です。']);
        }

        $product = Product::findOrFail($id);

        if ($product->user_id !== null && $product->user_id !== auth()->id()) {
            return redirect('/mypage')->withErrors(['product' => '他のユーザーの出品商品は編集できません。']);
        }

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect('/login')->withErrors(['email' => '商品編集にはログインが必要です。']);
        }

        $product = Product::findOrFail($id);

        if ($product->user_id !== null && $product->user_id !== auth()->id()) {
            return redirect('/mypage')->withErrors(['product' => '他のユーザーの出品商品は編集できません。']);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'user_id' => $product->user_id ?? auth()->id(),
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'stock' => $validated['stock'],
        ];

        if ($request->hasFile('image')) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect('/my-products/' . $product->id)->with('success', '出品商品情報を更新しました！');
    }

    public function destroy($id)
    {
        if (!auth()->check()) {
            return redirect('/login')->withErrors(['email' => '商品削除にはログインが必要です。']);
        }

        $product = Product::findOrFail($id);

        if ($product->user_id !== null && $product->user_id !== auth()->id()) {
            return redirect('/mypage')->withErrors(['product' => '他のユーザーの出品商品は削除できません。']);
        }

        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect('/mypage')->with('success', '出品商品を削除しました。');
    }
}
