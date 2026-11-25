<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->name }} を編集 - ECサイト</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 40px auto; padding: 0 20px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-weight: bold; margin-bottom: 6px; }
        input[type="text"], input[type="number"], textarea {
            width: 100%; box-sizing: border-box; padding: 8px 12px;
            border: 1px solid #ccc; border-radius: 6px; font-size: 1em;
        }
        textarea { min-height: 100px; }
        .error-box { background: #fef2f2; border: 1px solid #fca5a5; color: #b91c1c; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; }
        .actions { display: flex; gap: 10px; align-items: center; margin-top: 20px; }
        .btn { display: inline-block; text-decoration: none; color: #333; border: 1px solid #ccc; padding: 8px 14px; border-radius: 6px; background: #fff; cursor: pointer; }
        .btn-primary { background: #111; color: #fff; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>商品を編集</h1>

    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/products/{{ $product->id }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">商品名</label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="form-group">
            <label for="price">価格（円）</label>
            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" min="0" required>
        </div>

        <div class="form-group">
            <label for="stock">在庫数</label>
            <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required>
        </div>

        <div class="form-group">
            <label for="description">商品説明</label>
            <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="actions">
            <button type="submit" class="btn-primary">更新する</button>
            <a href="/products/{{ $product->id }}" class="btn">← 商品詳細に戻る</a>
        </div>
    </form>
</body>
</html>
