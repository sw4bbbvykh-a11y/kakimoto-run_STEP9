@extends('layouts.app')

@section('title', '出品商品詳細 - Cytech EC')

@section('content')
<div style="max-width: 720px; margin: 0 auto; background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 28px;">
    <h1 style="margin-top: 0;">出品商品詳細</h1>

    @if (session('success'))
        <div style="background: #eefbf3; border: 1px solid #2e8b57; color: #1f5c39; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom: 16px; line-height: 1.8;">
        <div><strong>商品番号：</strong>{{ $product->id }}</div>
        <div><strong>商品名：</strong>{{ $product->name }}</div>
        <div><strong>説明：</strong>{{ $product->description }}</div>
        <div><strong>金額：</strong>¥{{ number_format($product->price) }}</div>
        <div><strong>残り在庫：</strong>{{ $product->stock }}</div>
    </div>

    <div style="margin-bottom: 24px;">
        <div style="margin-bottom: 8px;"><strong>画像：</strong></div>
        @if ($product->image_path)
            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                 style="max-width: 320px; width: 100%; border-radius: 8px; border: 1px solid #e5e7eb; display: block;">
        @else
            <div style="padding: 36px; background: #f3f4f6; border-radius: 8px; color: #6b7280; text-align: center; max-width: 320px;">
                画像なし
            </div>
        @endif
    </div>

    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <a href="/products/{{ $product->id }}/edit" style="background: #2563eb; color: #fff; text-decoration: none; padding: 10px 18px; border-radius: 6px; font-weight: bold;">
            編集
        </a>
        <form action="/products/{{ $product->id }}" method="POST" style="margin: 0;"
              onsubmit="return confirm('この出品商品を削除しますか？');">
            @csrf
            @method('DELETE')
            <button type="submit" style="background: #dc2626; color: #fff; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer; font-weight: bold;">
                削除する
            </button>
        </form>
        <a href="/mypage" style="background: #6b7280; color: #fff; text-decoration: none; padding: 10px 18px; border-radius: 6px; font-weight: bold;">
            戻る
        </a>
    </div>
</div>
@endsection
