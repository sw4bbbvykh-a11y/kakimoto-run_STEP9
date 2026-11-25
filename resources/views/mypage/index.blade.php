@extends('layouts.app')

@section('title', 'マイページ - Cytech EC')

@section('content')
<div style="display: flex; flex-direction: column; gap: 24px;">
    @if (session('success'))
        <div style="background: #eefbf3; border: 1px solid #2e8b57; color: #1f5c39; padding: 12px 16px; border-radius: 6px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fca5a5; color: #b91c1c; padding: 12px 16px; border-radius: 6px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 16px;">
            <h1 style="margin: 0;">マイページ</h1>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="/mypage/edit" style="background: #2563eb; color: #fff; text-decoration: none; padding: 8px 16px; border-radius: 6px; font-weight: bold;">
                    アカウント編集
                </a>
                <a href="/products/create" style="background: #16a34a; color: #fff; text-decoration: none; padding: 8px 16px; border-radius: 6px; font-weight: bold;">
                    新規登録
                </a>
            </div>
        </div>

        <div style="line-height: 1.9;">
            <div><strong>ユーザ名：</strong>{{ $user->name }}</div>
            <div><strong>名前（漢字）：</strong>{{ $user->name_kanji }}</div>
            <div><strong>名前（カナ）：</strong>{{ $user->name_kana }}</div>
            <div><strong>Email Address：</strong>{{ $user->email }}</div>
        </div>
    </div>

    <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 24px;">
        <h2 style="margin-top: 0;">出品商品一覧</h2>

        @if ($myProducts->isEmpty())
            <p style="color: #6b7280;">まだ出品した商品はありません。</p>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e5e7eb; background: #f9fafb;">
                            <th style="padding: 10px;">商品番号</th>
                            <th style="padding: 10px;">商品名</th>
                            <th style="padding: 10px;">料金(¥)</th>
                            <th style="padding: 10px;">残り</th>
                            <th style="padding: 10px;">詳細</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($myProducts as $product)
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 10px;">{{ $product->id }}</td>
                                <td style="padding: 10px; font-weight: bold;">{{ $product->name }}</td>
                                <td style="padding: 10px;">{{ number_format($product->price) }}</td>
                                <td style="padding: 10px;">{{ $product->stock }}</td>
                                <td style="padding: 10px;">
                                    <a href="/my-products/{{ $product->id }}" style="background: #2563eb; color: #fff; text-decoration: none; padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: bold; display: inline-block;">
                                        詳細
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 24px;">
        <h2 style="margin-top: 0;">購入した商品一覧</h2>

        @if ($orders->isEmpty())
            <p style="color: #6b7280;">購入した商品はまだありません。</p>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e5e7eb; background: #f9fafb;">
                            <th style="padding: 10px;">注文番号</th>
                            <th style="padding: 10px;">商品名・数量</th>
                            <th style="padding: 10px;">合計金額(¥)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 10px;">{{ $order->id }}</td>
                                <td style="padding: 10px;">
                                    @foreach ($order->items as $item)
                                        <div>{{ $item->product_name }} × {{ $item->quantity }}個（¥{{ number_format($item->price) }}）</div>
                                    @endforeach
                                </td>
                                <td style="padding: 10px; font-weight: bold;">{{ number_format($order->total_price) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
