<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')->latest()->get();

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function store()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect('/cart')->with('success', 'カートが空のため注文できません。');
        }

        $order = DB::transaction(function () use ($cart) {
            $total = 0;

            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $order = Order::create([
                'total_price' => $total,
                'status' => 'completed',
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                ]);

                $product = Product::find($item['id']);
                if ($product) {
                    $product->stock = max(0, $product->stock - $item['quantity']);
                    $product->save();
                }
            }

            return $order;
        });

        session()->forget('cart');

        return redirect('/orders/complete/' . $order->id);
    }

    public function complete($id)
    {
        $order = Order::with('items')->findOrFail($id);

        return view('orders.complete', compact('order'));
    }
}
