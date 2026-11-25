@extends('layouts.app')

@section('title', '商品新規登録 - Cytech EC')

@section('content')
<div style="max-width: 640px; margin: 0 auto; background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 28px;">
    <h1 style="margin-top: 0;">商品新規登録</h1>

    @if ($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fca5a5; color: #b91c1c; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/products" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom: 16px;">
            <label for="name" style="display: block; font-weight: bold; margin-bottom: 6px;">商品名</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                   style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 16px;">
            <label for="price" style="display: block; font-weight: bold; margin-bottom: 6px;">価格（円）</label>
            <input type="number" id="price" name="price" value="{{ old('price', 1000) }}" min="0" required
                   style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 16px;">
            <label for="stock" style="display: block; font-weight: bold; margin-bottom: 6px;">在庫数</label>
            <input type="number" id="stock" name="stock" value="{{ old('stock', 10) }}" min="0" required
                   style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 16px;">
            <label for="image" style="display: block; font-weight: bold; margin-bottom: 6px;">商品画像（任意・2MBまで）</label>
            <input type="file" id="image" name="image" accept="image/*">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="description" style="display: block; font-weight: bold; margin-bottom: 6px;">商品説明</label>
            <textarea id="description" name="description" rows="4"
                      style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">{{ old('description') }}</textarea>
        </div>

        <div style="display: flex; gap: 10px; align-items: center;">
            <button type="submit" style="background: #2563eb; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: bold;">
                登録する
            </button>
            <a href="/mypage" style="background: #6b7280; color: #fff; text-decoration: none; padding: 10px 18px; border-radius: 6px; font-weight: bold;">
                戻る
            </a>
        </div>
    </form>
</div>
@endsection
