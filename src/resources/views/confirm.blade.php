<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>お問い合わせ確認</title>
    {{-- リセットCSS（Sanitize） --}}
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    {{-- 管理画面用スタイル --}}
    <link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
</head>

<body>
    <header class="header">
        <h1 class="logo">FashionablyLate</h1>
    </header>

    <main class="main">
        <h2 class="title">Confirm</h2>

        {{-- 確認フォーム --}}
        <form method="POST" action="{{ route('confirm') }}">
            @csrf

            <table class="confirm-table">
                {{-- お名前表示 --}}
                <tr>
                    <th>お名前</th>
                    <td>{{ $inputs['name'] ?? '' }}</td>
                </tr>

                {{-- 性別ラベル定義 --}}
                @php
                $genderLabels = [
                1 => '男性',
                2 => '女性',
                3 => 'その他',
                ];
                @endphp
                {{-- 性別表示 --}}
                <tr>
                    <th>性別</th>
                    <td>{{ $genderLabels[$inputs['gender']] ?? '未設定' }}</td>
                </tr>

                {{-- メールアドレス表示 --}}
                <tr>
                    <th>メールアドレス</th>
                    <td>{{ $inputs['email'] ?? '' }}</td>
                </tr>

                {{-- 電話番号表示 --}}
                <tr>
                    <th>電話番号</th>
                    <td>{{ $inputs['tel'] ?? '' }}</td>
                </tr>

                {{-- 住所表示 --}}
                <tr>
                    <th>住所</th>
                    <td>{{ $inputs['address'] ?? '' }}</td>
                </tr>

                {{-- 建物名表示 --}}
                <tr>
                    <th>建物名</th>
                    <td>{{ $inputs['building'] ?? '' }}</td>
                </tr>

                {{-- お問い合わせカテゴリラベル定義 --}}
                @php
                $categoryNames = [
                1 => '商品のお届けについて',
                2 => '商品の交換について',
                3 => '商品トラブル',
                4 => 'ショップへのお問い合わせ',
                5 => 'その他',
                ];
                @endphp
                {{-- お問い合わせカテゴリ表示 --}}
                <tr>
                    <th>お問い合わせの種類</th>
                    <td>{{ $categoryNames[$inputs['category_id']] ?? '未設定' }}</td>
                </tr>

                {{-- お問い合わせ内容表示 --}}
                <tr>
                    <th>お問い合わせ内容</th>
                    <td>{!! nl2br(e($inputs['detail'] ?? '' )) !!}</td>
                </tr>
            </table>

            {{-- 隠しフィールドで全入力値を送信 --}}
            @foreach($inputs as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            {{-- 送信・修正ボタン --}}
            <div class="button-area">
                <button type="submit" name="action" value="submit" class="submit-button">送信</button>
                <button type="submit" name="action" value="back" class="back-button">修正</button>
            </div>
        </form>
    </main>
</body>

</html>