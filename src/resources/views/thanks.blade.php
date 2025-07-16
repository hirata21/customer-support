<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ完了</title>
    {{-- リセットCSS（Sanitize） --}}
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    {{-- サンクスページ用カスタムCSS --}}
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
</head>

<body>
    <div class="thank-you-container">
        {{-- 背景に装飾的な "Thank you" 表示 --}}
        <div class="background-text">Thank you</div>

        {{-- メインメッセージ --}}
        <h2 class="message">お問い合わせありがとうございました</h2>

        {{-- HOMEボタン --}}
        <a href="/" class="home-button">HOME</a>
    </div>
</body>

</html>