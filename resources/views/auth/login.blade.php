@extends('layouts.app')

@section('title', 'ログイン - Cytech EC')

@section('content')
<div style="max-width: 560px; margin: 0 auto; background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 28px;">
    <h1 style="margin-top: 0;">ログイン</h1>

    @if ($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fca5a5; color: #b91c1c; padding: 12px 14px; border-radius: 6px; margin-bottom: 18px;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="/login" method="POST">
        @csrf

        <div style="margin-bottom: 16px;">
            <label for="email" style="display: block; font-weight: bold; margin-bottom: 6px;">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                   style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 16px;">
            <label for="password" style="display: block; font-weight: bold; margin-bottom: 6px;">Password</label>
            <input type="password" id="password" name="password" required
                   style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: inline-flex; align-items: center; gap: 6px; cursor: pointer;">
                <input type="checkbox" name="remember">
                <span>Remember Me</span>
            </label>
        </div>

        <div style="display: flex; gap: 12px; align-items: center;">
            <button type="submit" style="background: #2563eb; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: bold;">
                Login
            </button>
            <a href="/register" style="color: #2563eb; text-decoration: none;">新規ユーザ登録はこちら</a>
        </div>
    </form>
</div>
@endsection
