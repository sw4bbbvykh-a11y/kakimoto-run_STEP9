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

        $result = DB::transaction(function () use ($cart) {
            $total = 0;
            $products = [];

            foreach ($cart as $item) {
                $product = Product::lockForUpdate()->find($item['id']);
                if (!$product || $product->stock < $item['quantity']) {
                    return [
                        'ok' => false,
                        'message' => ($item['name'] ?? '商品') . ' の在庫が不足しているため注文できません。',
                    ];
                }
                $products[$item['id']] = $product;
                $total += $product->price * $item['quantity'];
            }

            $order = Order::create([
                'total_price' => $total,
                'status' => 'completed',
            ]);

            foreach ($cart as $item) {
                $product = $products[$item['id']];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                ]);

                $product->stock -= $item['quantity'];
                $product->save();
            }

            return [
                'ok' => true,
                'order' => $order,
            ];
        });

        if (!$result['ok']) {
            return redirect('/cart')->with('success', $result['message']);
        }

        session()->forget('cart');

        return redirect('/orders/complete/' . $result['order']->id);
    }

    public function cancel($id)
    {
        $result = DB::transaction(function () use ($id) {
            $order = Order::with('items')->lockForUpdate()->findOrFail($id);

            if ($order->status === 'cancelled') {
                return [
                    'ok' => false,
                    'message' => 'この注文はすでにキャンセルされています。',
                ];
            }

            foreach ($order->items as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);
                if ($product) {
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }

            $order->status = 'cancelled';
            $order->save();

            return [
                'ok' => true,
                'message' => '注文をキャンセルし、在庫を元に戻しました。',
            ];
        });

        return redirect('/orders/' . $id)->with('success', $result['message']);
    }

    public function complete($id)
    {
        $order = Order::with('items')->findOrFail($id);

        return view('orders.complete', compact('order'));
    }
}
