<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PurchaseController extends Controller
{
    public function store(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'message' => '指定された商品が見つかりません。',
            ], 404);
        }

        if ($product->stock <= 0) {
            return response()->json([
                'message' => '残り在庫が0のため購入できません。',
                'remaining_stock' => $product->stock,
            ], 422);
        }

        try {
            $validated = $request->validate([
                'quantity' => ['required', 'integer', 'min:1', 'max:' . $product->stock],
                'user_id' => ['nullable', 'integer', 'exists:users,id'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => '入力内容に誤りがあります。',
                'errors' => $e->errors(),
            ], 422);
        }

        $userId = $validated['user_id'] ?? (auth()->id() ?? $product->user_id);

        try {
            $result = DB::transaction(function () use ($id, $validated, $userId) {
                $target = Product::lockForUpdate()->findOrFail($id);

                if ($target->stock < $validated['quantity']) {
                    return [
                        'error' => '在庫が不足しています。',
                        'remaining_stock' => $target->stock,
                    ];
                }

                $total = $target->price * $validated['quantity'];

                $order = Order::create([
                    'user_id' => $userId,
                    'total_price' => $total,
                    'status' => 'completed',
                ]);

                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $target->id,
                    'product_name' => $target->name,
                    'price' => $target->price,
                    'quantity' => $validated['quantity'],
                ]);

                $target->stock -= $validated['quantity'];
                $target->save();

                return [
                    'order' => $order,
                    'order_item' => $orderItem,
                    'product' => $target->fresh(),
                ];
            });
        } catch (\Throwable $e) {
            return response()->json([
                'message' => '購入処理中にエラーが発生しました。',
            ], 500);
        }

        if (isset($result['error'])) {
            return response()->json([
                'message' => $result['error'],
                'remaining_stock' => $result['remaining_stock'],
            ], 422);
        }

        return response()->json([
            'message' => '購入が完了しました。',
            'data' => [
                'order_id' => $result['order']->id,
                'user_id' => $result['order']->user_id,
                'product_id' => $result['product']->id,
                'product_name' => $result['product']->name,
                'unit_price' => $result['order_item']->price,
                'quantity' => $result['order_item']->quantity,
                'total_price' => $result['order']->total_price,
                'remaining_stock' => $result['product']->stock,
            ],
        ], 201);
    }
}
