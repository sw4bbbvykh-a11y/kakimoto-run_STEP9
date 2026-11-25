<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品一覧 - ECサイト</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 40px auto; padding: 0 20px; }
        .message { background: #eefbf3; border: 1px solid #2e8b57; color: #1f5c39; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; }
        .nav { margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap; }
        .search-form { margin-bottom: 24px; display: flex; gap: 8px; }
        .search-form input[type="text"] { flex: 1; padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px; }
        .btn { display: inline-block; text-decoration: none; color: #333; border: 1px solid #ccc; padding: 8px 14px; border-radius: 6px; background: #fff; cursor: pointer; }
        .btn-primary { background: #111; color: #fff; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; text-decoration: none; display: inline-block; }
        .product { border: 1px solid #ddd; border-radius: 8px; padding: 16px; margin-bottom: 16px; }
        .product a { text-decoration: none; color: #111; }
        .product a:hover { text-decoration: underline; }
        .price { font-weight: bold; color: #e60033; font-size: 1.2em; }
    </style>
</head>
<body>
    <h1>商品一覧</h1>

    @if (session('success'))
        <div class="message">{{ session('success') }}</div>
    @endif

    <div class="nav">
        <a href="/products/create" class="btn-primary">＋ 商品を登録する</a>
        <a href="/cart" class="btn">カートを見る</a>
        <a href="/orders" class="btn">注文履歴を見る</a>
    </div>

    <form action="/products" method="GET" class="search-form">
        <input type="text" name="keyword" value="{{ $keyword ?? '' }}" placeholder="商品名や説明で検索...">
        <button type="submit" class="btn-primary">検索</button>
        @if (!empty($keyword))
            <a href="/products" class="btn">リセット</a>
        @endif
    </form>

    @if ($products->isEmpty())
        <p>該当する商品は見つかりませんでした。</p>
    @else
        @foreach ($products as $product)
            <div class="product">
                <h2><a href="/products/{{ $product->id }}">{{ $product->name }}</a></h2>
                <p class="price">¥{{ number_format($product->price) }}</p>
                <p>{{ $product->description }}</p>
                <p>在庫数：{{ $product->stock }}個</p>
            </div>
        @endforeach
    @endif
</body>
</html>
