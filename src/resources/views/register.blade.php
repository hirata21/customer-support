<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>登録ページ</title>
    {{-- リセットCSS（Sanitize） --}}
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    {{-- ログイン画面用スタイル --}}
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body>
    <header class="header">
        <h1 class="logo">FashionablyLate</h1>
        <div class="header-right">
            {{-- ログインページへのリンク --}}
            <a href="/login" class="header-button">login</a>
        </div>
    </header>

    <main>
        <h2 class="Register-title">Register</h2>

        <div class="form-box">
            <form method="post" action="{{ route('register') }}">
                @csrf

                {{-- 名前入力欄 --}}
                <div class="form-group">
                    <label for="email">お名前</label>
                    <input type="name" id="name" name="name" placeholder="例: 山田 太郎" value="{{ old('name') }}">
                    {{-- バリデーションエラー表示（name） --}}
                    @error('name')
                        <div style="color:red;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- メールアドレス入力欄 --}}
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="text" id="email" name="email" placeholder="例: test@example.com" value="{{ old('email') }}">
                    {{-- バリデーションエラー表示（email） --}}
                    @error('email')
                        <div style=" color:red;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- パスワード入力欄 --}}
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" id="password" name="password" placeholder="例: coachtech1106"
                        value="{{ old('password') }}">
                    {{-- バリデーションエラー表示（password） --}}
                    @error('password')
                        <div style=" color:red;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 登録ボタン --}}
                <div class="button-wrapper">
                    <button type="submit" class="register-button">登録</button>
                </div>

                {{-- 登録成功時のメッセージ表示 --}}
                @if(session('success'))
                <div style="color:green;">{{ session('success') }}</div>
                @endif
            </form>
        </div>
    </main>
</body>

</html>