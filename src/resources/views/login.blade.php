<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ログイン画面</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <header class="header">
        <h1 class="logo">FashionablyLate</h1>
        {{-- 登録ページへのリンク --}}
        <div class="header-right">
            <a href="/register" class="header-button">register</a>
        </div>
    </header>

    <main>
        <h2 class="login-title">Login</h2>
        <div class="login-box">
            <form method="post" action="{{ route('login') }}">
                @csrf

                {{-- メールアドレス入力 --}}
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="text" id="email" name="email" placeholder="例: test@example.com"
                        value="{{ old('email') }}">
                    {{-- バリデーションエラー表示（email） --}}
                    @error('email')
                    <div style=" color:red;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- パスワード入力 --}}
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" id="password" name="password" placeholder="例: coachtech1106">
                    {{-- バリデーションエラー表示（password） --}}
                    @error('password')
                        <div style=" color:red;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ログインボタン --}}
                <div class="button-wrapper">
                    <button type="submit" class="login-button">ログイン</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>