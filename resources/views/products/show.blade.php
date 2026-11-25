<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->name }} - 商品詳細</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 40px auto; padding: 0 20px; }
        .card { border: 1px solid #ddd; border-radius: 8px; padding: 24px; margin-bottom: 20px; }
        .price { font-weight: bold; color: #e60033; font-size: 1.4em; }
        .back-link { display: inline-block; text-decoration: none; color: #333; border: 1px solid #ccc; padding: 8px 14px; border-radius: 6px; }
    </style>
</head>
<body>
    <h1>{{ $product->name }}</h1>
    <div class="card">
        <p class="price">¥{{ number_format($product->price) }}</p>
        <p>{{ $product->description }}</p>
        <p>在庫数：{{ $product->stock }}個</p>
    </div>
    <a href="/products" class="back-link">← 商品一覧に戻る</a>
</body>
</html>
