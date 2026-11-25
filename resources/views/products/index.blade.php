@extends('layouts.app')

@section('title', '商品一覧 - Cytech EC')

@section('content')
<div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
        <h1 style="margin: 0;">商品一覧</h1>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="/products/create" style="background: #2563eb; color: #fff; text-decoration: none; padding: 8px 14px; border-radius: 6px; font-weight: bold;">＋ 商品を登録する</a>
            <a href="/cart" style="background: #fff; color: #374151; border: 1px solid #cbd5e1; text-decoration: none; padding: 8px 14px; border-radius: 6px;">カートを見る</a>
            <a href="/orders" style="background: #fff; color: #374151; border: 1px solid #cbd5e1; text-decoration: none; padding: 8px 14px; border-radius: 6px;">注文履歴を見る</a>
        </div>
    </div>

    @if (session('success'))
        <div style="background: #eefbf3; border: 1px solid #2e8b57; color: #1f5c39; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <form action="/products" method="GET" style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center; margin-bottom: 24px;">
        <input type="text" name="keyword" value="{{ $keyword ?? '' }}" placeholder="商品名を入力"
               style="flex: 1; min-width: 180px; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        <input type="number" name="min_price" value="{{ $minPrice ?? '' }}" placeholder="最低価格" min="0"
               style="width: 120px; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        <span>〜</span>
        <input type="number" name="max_price" value="{{ $maxPrice ?? '' }}" placeholder="最高価格" min="0"
               style="width: 120px; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        <button type="submit" style="background: #2563eb; color: #fff; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: bold;">検索</button>
        @if (!empty($keyword) || ($minPrice ?? '') !== '' || ($maxPrice ?? '') !== '')
            <a href="/products" style="background: #fff; color: #374151; border: 1px solid #cbd5e1; text-decoration: none; padding: 8px 12px; border-radius: 6px;">リセット</a>
        @endif
    </form>

    @if ($products->isEmpty())
        <p>該当する商品は見つかりませんでした。</p>
    @else
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid #e5e7eb; background: #f9fafb;">
                        <th style="padding: 10px;">商品番号</th>
                        <th style="padding: 10px;">商品名</th>
                        <th style="padding: 10px;">商品説明</th>
                        <th style="padding: 10px;">画像</th>
                        <th style="padding: 10px;">料金(¥)</th>
                        <th style="padding: 10px;">詳細</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 10px;">{{ $product->id }}</td>
                            <td style="padding: 10px; font-weight: bold;">{{ $product->name }}</td>
                            <td style="padding: 10px;">{{ $product->description }}</td>
                            <td style="padding: 10px;">
                                @if ($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                                         style="width: 64px; height: 64px; object-fit: cover; border-radius: 4px; border: 1px solid #e5e7eb;">
                                @else
                                    <span style="color: #9ca3af; font-size: 0.85rem;">画像なし</span>
                                @endif
                            </td>
                            <td style="padding: 10px;">{{ number_format($product->price) }}</td>
                            <td style="padding: 10px;">
                                <a href="/products/{{ $product->id }}" style="background: #16a34a; color: #fff; text-decoration: none; padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: bold; display: inline-block;">詳細</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
