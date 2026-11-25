<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ショッピングカート - ECサイト</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 40px auto; padding: 0 20px; }
        .message { background: #eefbf3; border: 1px solid #2e8b57; color: #1f5c39; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; }
        .item { border: 1px solid #ddd; border-radius: 8px; padding: 16px; margin-bottom: 14px; display: flex; justify-content: space-between; align-items: center; }
        .total { font-size: 1.3em; font-weight: bold; margin: 24px 0; }
        .actions { display: flex; gap: 12px; align-items: center; margin-top: 16px; }
        .btn { display: inline-block; text-decoration: none; color: #333; border: 1px solid #ccc; padding: 8px 14px; border-radius: 6px; background: #fff; cursor: pointer; }
        .btn-primary { background: #111; color: #fff; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer; }
        .btn-danger { color: #b91c1c; border-color: #fca5a5; }
    </style>
</head>
<body>
    <h1>ショッピングカート</h1>

    @if (session('success'))
        <div class="message">{{ session('success') }}</div>
    @endif

    @if (empty($cart))
        <p>カートに商品は入っていません。</p>
    @else
        @foreach ($cart as $item)
            <div class="item">
                <div>
                    <h2>{{ $item['name'] }}</h2>
                    <p>単価：¥{{ number_format($item['price']) }} × {{ $item['quantity'] }}個</p>
                    <p>小計：¥{{ number_format($item['price'] * $item['quantity']) }}</p>
                </div>
                <form action="/cart/remove/{{ $item['id'] }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">削除</button>
                </form>
            </div>
        @endforeach

        <p class="total">合計金額：¥{{ number_format($total) }}</p>

        <form action="/orders" method="POST">
            @csrf
            <button type="submit" class="btn-primary">注文を確定する</button>
        </form>
    @endif

    <div class="actions">
        <a href="/products" class="btn">← 商品一覧に戻る</a>
    </div>
</body>
</html>
