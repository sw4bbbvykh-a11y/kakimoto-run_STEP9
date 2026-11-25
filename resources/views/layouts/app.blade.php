<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cytech EC')</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: sans-serif;
            background: #f8fafc;
            color: #111827;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .site-header {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 14px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }
        .brand {
            font-size: 1.25rem;
            font-weight: bold;
            color: #111827;
            text-decoration: none;
        }
        .header-right {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
            font-size: 0.95rem;
        }
        .header-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }
        .header-link:hover { text-decoration: underline; }
        .user-label { color: #374151; }
        .btn-logout {
            background: #dc2626;
            color: #ffffff;
            border: none;
            padding: 7px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: bold;
        }
        .main-container {
            flex: 1;
            width: 100%;
            max-width: 960px;
            margin: 32px auto;
            padding: 0 20px;
        }
        .site-footer {
            background: #ffffff;
            border-top: 1px solid #e5e7eb;
            padding: 24px 20px;
            text-align: center;
            color: #6b7280;
            font-size: 0.9rem;
        }
        .footer-contact-wrap { margin-bottom: 12px; }
        .btn-contact {
            display: inline-block;
            background: #2563eb;
            color: #ffffff;
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 6px;
            font-weight: bold;
        }
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 18px;
            margin-bottom: 12px;
        }
        .footer-links a {
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header class="site-header">
        <a href="/products" class="brand">Cytech EC</a>
        <div class="header-right">
            <a href="/products" class="header-link">Home</a>
            @auth
                <a href="/mypage" class="header-link">マイページ</a>
                <span class="user-label">ログインユーザー: {{ auth()->user()->name }}</span>
                <form action="/logout" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-logout">ログアウト</button>
                </form>
            @else
                <a href="/login" class="header-link">ログイン</a>
                <a href="/register" class="header-link">新規ユーザ登録</a>
            @endauth
        </div>
    </header>

    <main class="main-container">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="footer-contact-wrap">
            <a href="/contact" class="btn-contact">お問い合わせ</a>
        </div>
        <div class="footer-links">
            <a href="/products">Home</a>
            <a href="/mypage">マイページ</a>
        </div>
        <div>© 2024 Company, Inc</div>
    </footer>
</body>
</html>
