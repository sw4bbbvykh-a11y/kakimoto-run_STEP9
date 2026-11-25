<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文履歴 - ECサイト</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 40px auto; padding: 0 20px; }
        .order { border: 1px solid #ddd; border-radius: 8px; padding: 16px; margin-bottom: 16px; }
        .order-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
        .btn { display: inline-block; text-decoration: none; color: #333; border: 1px solid #ccc; padding: 8px 14px; border-radius: 6px; margin-right: 8px; }
    </style>
</head>
<body>
    <h1>注文履歴</h1>

    @if ($orders->isEmpty())
        <p>まだ注文履歴はありません。</p>
    @else
        @foreach ($orders as $order)
            <div class="order">
                <div class="order-header">
                    <strong>注文番号：#{{ $order->id }}</strong>
                    <span>{{ $order->created_at->format('Y/m/d H:i') }}</span>
                </div>
                <p>合計金額：¥{{ number_format($order->total_price) }}</p>
                <p>商品数：{{ $order->items->sum('quantity') }}点</p>
                <a href="/orders/{{ $order->id }}" class="btn">注文詳細を見る</a>
            </div>
        @endforeach
    @endif

    <div style="margin-top: 20px;">
        <a href="/products" class="btn">← 商品一覧に戻る</a>
        <a href="/cart" class="btn">カートを見る</a>
    </div>
</body>
</html>
