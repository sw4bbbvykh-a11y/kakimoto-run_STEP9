<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品一覧 - ECサイト</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 40px auto; padding: 0 20px; }
        .nav { margin-bottom: 20px; display: flex; gap: 10px; }
        .btn { display: inline-block; text-decoration: none; color: #333; border: 1px solid #ccc; padding: 8px 14px; border-radius: 6px; }
        .product { border: 1px solid #ddd; border-radius: 8px; padding: 16px; margin-bottom: 16px; }
        .product a { text-decoration: none; color: #111; }
        .product a:hover { text-decoration: underline; }
        .price { font-weight: bold; color: #e60033; font-size: 1.2em; }
    </style>
</head>
<body>
    <h1>商品一覧</h1>
    <div class="nav">
        <a href="/cart" class="btn">カートを見る</a>
        <a href="/orders" class="btn">注文履歴を見る</a>
    </div>
    @foreach ($products as $product)
        <div class="product">
            <h2><a href="/products/{{ $product->id }}">{{ $product->name }}</a></h2>
            <p class="price">¥{{ number_format($product->price) }}</p>
            <p>{{ $product->description }}</p>
            <p>在庫数：{{ $product->stock }}個</p>
        </div>
    @endforeach
</body>
</html>
