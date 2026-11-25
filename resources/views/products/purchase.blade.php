@extends('layouts.app')

@section('title', '購入画面 - Cytech EC')

@section('content')
<div style="max-width: 720px; margin: 0 auto; background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 28px;">
    <h1 style="margin-top: 0;">購入画面</h1>

    @if ($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fca5a5; color: #b91c1c; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="margin-bottom: 16px; line-height: 1.7;">
        <div><strong>商品名：</strong>{{ $product->name }}</div>
        <div><strong>説明：</strong>{{ $product->description }}</div>
    </div>

    <div style="margin-bottom: 20px;">
        @if ($product->image_path)
            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                 style="max-width: 320px; width: 100%; border-radius: 8px; border: 1px solid #e5e7eb; display: block;">
        @else
            <div style="padding: 36px; background: #f3f4f6; border-radius: 8px; color: #6b7280; text-align: center; max-width: 320px;">
                画像なし
            </div>
        @endif
    </div>

    @if ($product->stock > 0)
        <form action="/products/{{ $product->id }}/purchase" method="POST">
            @csrf

            <div style="margin-bottom: 16px;">
                <label for="quantity" style="display: block; font-weight: bold; margin-bottom: 6px;">購入個数</label>
                <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" max="{{ $product->stock }}" required
                       style="width: 110px; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 20px; line-height: 1.8;">
                <div><strong>金額：</strong>¥{{ number_format($product->price) }}</div>
                <div><strong>残り：</strong>{{ $product->stock }}</div>
                <div><strong>会社：</strong>{{ optional($product->user)->name ?? 'TNG' }}</div>
            </div>

            <div style="display: flex; gap: 10px; align-items: center;">
                <button type="submit" style="background: #2563eb; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: bold;">
                    購入する
                </button>
                <a href="/products/{{ $product->id }}" style="background: #6b7280; color: #fff; text-decoration: none; padding: 10px 18px; border-radius: 6px; font-weight: bold;">
                    戻る
                </a>
            </div>
        </form>
    @else
        <div style="margin-bottom: 20px; line-height: 1.8;">
            <div style="color: #dc2626; font-weight: bold;">残り在庫が0のため購入できません。</div>
            <div><strong>金額：</strong>¥{{ number_format($product->price) }}</div>
            <div><strong>残り：</strong>0</div>
            <div><strong>会社：</strong>{{ optional($product->user)->name ?? 'TNG' }}</div>
        </div>
        <a href="/products/{{ $product->id }}" style="background: #6b7280; color: #fff; text-decoration: none; padding: 10px 18px; border-radius: 6px; font-weight: bold; display: inline-block;">
            戻る
        </a>
    @endif
</div>
@endsection
