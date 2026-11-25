@extends('layouts.app')

@section('title', '商品編集 - Cytech EC')

@section('content')
<div style="max-width: 640px; margin: 0 auto; background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 28px;">
    <h1 style="margin-top: 0;">商品編集</h1>

    @if ($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fca5a5; color: #b91c1c; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 16px;">
            <label for="name" style="display: block; font-weight: bold; margin-bottom: 6px;">商品名</label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
                   style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 16px;">
            <label for="price" style="display: block; font-weight: bold; margin-bottom: 6px;">価格（円）</label>
            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" min="0" required
                   style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 16px;">
            <label for="stock" style="display: block; font-weight: bold; margin-bottom: 6px;">在庫数</label>
            <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                   style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 16px;">
            <label for="image" style="display: block; font-weight: bold; margin-bottom: 6px;">商品画像（変更する場合のみ選択・2MBまで）</label>
            @if ($product->image_path)
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                     style="max-width: 200px; border-radius: 6px; border: 1px solid #e5e7eb; display: block; margin-bottom: 8px;">
            @endif
            <input type="file" id="image" name="image" accept="image/*">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="description" style="display: block; font-weight: bold; margin-bottom: 6px;">商品説明</label>
            <textarea id="description" name="description" rows="4"
                      style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">{{ old('description', $product->description) }}</textarea>
        </div>

        <div style="display: flex; gap: 10px; align-items: center;">
            <button type="submit" style="background: #2563eb; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: bold;">
                更新する
            </button>
            <a href="/my-products/{{ $product->id }}" style="background: #6b7280; color: #fff; text-decoration: none; padding: 10px 18px; border-radius: 6px; font-weight: bold;">
                戻る
            </a>
        </div>
    </form>
</div>
@endsection
