@extends('layouts.app')

@section('title', 'お問い合わせ - Cytech EC')

@section('content')
<div style="max-width: 640px; margin: 0 auto; background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 28px;">
    <h1 style="margin-top: 0;">お問い合わせ</h1>

    @if (session('success'))
        <div style="background: #eefbf3; border: 1px solid #2e8b57; color: #1f5c39; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fca5a5; color: #b91c1c; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/contact" method="POST">
        @csrf

        <div style="margin-bottom: 16px;">
            <label for="name" style="display: block; font-weight: bold; margin-bottom: 6px;">お名前</label>
            <input type="text" id="name" name="name" value="{{ old('name', $defaultName) }}" required
                   style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 16px;">
            <label for="email" style="display: block; font-weight: bold; margin-bottom: 6px;">メールアドレス</label>
            <input type="email" id="email" name="email" value="{{ old('email', $defaultEmail) }}" required
                   style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 16px;">
            <label for="subject" style="display: block; font-weight: bold; margin-bottom: 6px;">件名</label>
            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                   style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="message" style="display: block; font-weight: bold; margin-bottom: 6px;">お問い合わせ内容</label>
            <textarea id="message" name="message" rows="5" required
                      style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">{{ old('message') }}</textarea>
        </div>

        <div style="display: flex; gap: 10px; align-items: center;">
            <button type="submit" style="background: #2563eb; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: bold;">
                送信
            </button>
            <a href="/products" style="background: #6b7280; color: #fff; text-decoration: none; padding: 10px 18px; border-radius: 6px; font-weight: bold;">
                戻る
            </a>
        </div>
    </form>
</div>
@endsection
