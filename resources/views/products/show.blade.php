@extends('layouts.app')

@section('title', '商品詳細 - Cytech EC')

@section('content')
<div style="max-width: 720px; margin: 0 auto; background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 28px;">
    <h1 style="margin-top: 0;">商品詳細</h1>

    @if (session('success'))
        <div style="background: #eefbf3; border: 1px solid #2e8b57; color: #1f5c39; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom: 16px; line-height: 1.7;">
        <div><strong>商品名：</strong>{{ $product->name }}</div>
        <div><strong>説明：</strong>{{ $product->description }}</div>
    </div>

    <div style="margin-bottom: 20px;">
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

    <div style="margin-bottom: 16px; line-height: 1.8;">
        <div><strong>金額：</strong>¥{{ number_format($product->price) }}</div>
        <div><strong>会社：</strong>{{ optional($product->user)->name ?? 'TNG' }}</div>
        <div><strong>残り在庫：</strong>{{ $product->stock }}個</div>
    </div>

    <div style="margin-bottom: 20px;">
        <form action="/products/{{ $product->id }}/favorite" method="POST" style="display: inline;">
            @csrf
            <button type="submit" title="お気に入り"
                    style="background: transparent; border: none; padding: 4px 8px; cursor: pointer; font-size: 1.6rem; line-height: 1; color: {{ $isFavorited ? '#dc2626' : '#9ca3af' }};">
                {{ $isFavorited ? '♥' : '♡' }}
            </button>
        </form>
    </div>

    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        @if ($product->stock > 0)
            <form action="/cart/add/{{ $product->id }}" method="POST" style="display: inline-flex; gap: 8px; align-items: center; margin: 0;">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" style="background: #2563eb; color: #fff; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer; font-weight: bold;">
                    カートに追加する
                </button>
            </form>
            <a href="/products/{{ $product->id }}/purchase" style="background: #16a34a; color: #fff; text-decoration: none; padding: 10px 18px; border-radius: 6px; font-weight: bold;">
                購入画面へ
            </a>
        @else
            <span style="color: #dc2626; font-weight: bold;">現在在庫切れです</span>
        @endif
        <a href="/products" style="background: #6b7280; color: #fff; text-decoration: none; padding: 10px 18px; border-radius: 6px; font-weight: bold;">
            戻る
        </a>
    </div>
</div>
@endsection
