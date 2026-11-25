<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->name }} - 商品詳細</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 40px auto; padding: 0 20px; }
        .message { background: #eefbf3; border: 1px solid #2e8b57; color: #1f5c39; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; }
        .card { border: 1px solid #ddd; border-radius: 8px; padding: 24px; margin-bottom: 20px; }
        .price { font-weight: bold; color: #e60033; font-size: 1.4em; }
        .cart-form { margin: 20px 0; display: flex; gap: 10px; align-items: center; }
        .cart-form input[type="number"] { width: 70px; padding: 8px; border: 1px solid #ccc; border-radius: 6px; }
        .btn-primary { background: #111; color: #fff; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer; }
        .btn { display: inline-block; text-decoration: none; color: #333; border: 1px solid #ccc; padding: 8px 14px; border-radius: 6px; background: #fff; cursor: pointer; }
        .btn-danger { color: #b91c1c; border-color: #fca5a5; }
        .footer-actions { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
    </style>
</head>
<body>
    <h1>{{ $product->name }}</h1>

    @if (session('success'))
        <div class="message">{{ session('success') }}</div>
    @endif

    <div class="card">
        <p class="price">¥{{ number_format($product->price) }}</p>
        <p>{{ $product->description }}</p>
        <p>在庫数：{{ $product->stock }}個</p>

        @if ($product->stock > 0)
            <form action="/cart/add/{{ $product->id }}" method="POST" class="cart-form">
                @csrf
                <label>数量：
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}">
                </label>
                <button type="submit" class="btn-primary">カートに入れる</button>
            </form>
        @else
            <p style="color: #b91c1c; font-weight: bold;">現在在庫切れです</p>
        @endif
    </div>

    <div class="footer-actions">
        <a href="/products" class="btn">← 商品一覧に戻る</a>
        <a href="/products/{{ $product->id }}/edit" class="btn">編集する</a>
        <form action="/products/{{ $product->id }}" method="POST" onsubmit="return confirm('この商品を削除しますか？');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">削除する</button>
        </form>
    </div>
</body>
</html>
