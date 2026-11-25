<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文詳細 #{{ $order->id }} - ECサイト</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 40px auto; padding: 0 20px; }
        .box { border: 1px solid #ddd; border-radius: 8px; padding: 24px; margin-bottom: 20px; }
        .item { border-bottom: 1px solid #eee; padding: 10px 0; }
        .total { font-size: 1.3em; font-weight: bold; margin-top: 16px; }
        .btn { display: inline-block; text-decoration: none; color: #333; border: 1px solid #ccc; padding: 8px 14px; border-radius: 6px; margin-right: 8px; }
    </style>
</head>
<body>
    <h1>注文詳細 #{{ $order->id }}</h1>
    <div class="box">
        <p>注文日時：{{ $order->created_at->format('Y/m/d H:i') }}</p>
        <p>ステータス：{{ $order->status }}</p>
        @foreach ($order->items as $item)
            <div class="item">
                <strong>{{ $item->product_name }}</strong> × {{ $item->quantity }}個
                （単価：¥{{ number_format($item->price) }} / 小計：¥{{ number_format($item->price * $item->quantity) }}）
            </div>
        @endforeach
        <p class="total">合計金額：¥{{ number_format($order->total_price) }}</p>
    </div>
    <a href="/orders" class="btn">← 注文履歴一覧に戻る</a>
    <a href="/products" class="btn">商品一覧に戻る</a>
</body>
</html>
