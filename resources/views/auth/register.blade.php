@extends('layouts.app')

@section('title', '新規ユーザ登録 - Cytech EC')

@section('content')
<div style="max-width: 560px; margin: 0 auto; background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 28px;">
    <h1 style="margin-top: 0;">新規ユーザ登録</h1>

    @if ($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fca5a5; color: #b91c1c; padding: 12px 14px; border-radius: 6px; margin-bottom: 18px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/register" method="POST">
        @csrf

        <div style="margin-bottom: 14px;">
            <label for="name" style="display: block; font-weight: bold; margin-bottom: 6px;">Name（ユーザ名）</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                   style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 14px;">
            <label for="name_kanji" style="display: block; font-weight: bold; margin-bottom: 6px;">名前（漢字）</label>
            <input type="text" id="name_kanji" name="name_kanji" value="{{ old('name_kanji') }}" required
                   style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 14px;">
            <label for="name_kana" style="display: block; font-weight: bold; margin-bottom: 6px;">名前（カナ）</label>
            <input type="text" id="name_kana" name="name_kana" value="{{ old('name_kana') }}" required
                   style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 14px;">
            <label for="email" style="display: block; font-weight: bold; margin-bottom: 6px;">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                   style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 14px;">
            <label for="password" style="display: block; font-weight: bold; margin-bottom: 6px;">Password</label>
            <input type="password" id="password" name="password" required
                   style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password_confirmation" style="display: block; font-weight: bold; margin-bottom: 6px;">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                   style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        </div>

        <div style="display: flex; gap: 12px; align-items: center;">
            <button type="submit" style="background: #2563eb; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: bold;">
                Register
            </button>
            <a href="/login" style="color: #2563eb; text-decoration: none;">ログイン画面に戻る</a>
        </div>
    </form>
</div>
@endsection
