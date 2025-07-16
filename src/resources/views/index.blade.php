<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>お問い合わせフォーム入力画面</title>
    {{-- リセットCSS（Sanitize） --}}
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    {{-- フォーム用カスタムCSS --}}
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>

<body>
    <header class="header">
        <h1 class="logo">FashionablyLate</h1>
    </header>

    {{-- メインコンテンツ --}}
    <main class="main">
        <h2 class="title">Contact</h2>

        <form method="post" action="{{ route('confirm') }}">
            @csrf
            <table class="form-table">
                {{-- お名前入力（姓・名） --}}
                <tr>
                    <th>お名前 <span class="required">※</span></th>
                    <td>
                        <div style="display:flex; gap:10px;">
                            {{-- 姓 --}}
                            <div style="flex:1;">
                                <input type="text" name="last_name" placeholder="例: 山田" value="{{ old('last_name') }}">
                                @error('last_name')
                                <div style=" color:red;">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 名 --}}
                            <div style="flex:1;">
                                <input type="text" name="first_name" placeholder="例: 太郎" value="{{ old('first_name') }}">
                                @error('first_name')
                                <div style=" color:red;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- 性別選択（ラジオボタン） --}}
                <tr>
                    <th>性別 <span class="required">※</span></th>
                    <td class="radio-group">
                        <label><input type="radio" name="gender" value="1" {{ old('gender', '1') == '1' ? 'checked' : '' }}> 男性</label>
                        <label><input type="radio" name="gender" value="2" {{ old('gender', '1') == '2' ? 'checked' : '' }}> 女性</label>
                        <label><input type="radio" name="gender" value="3" {{ old('gender', '1') == '3' ? 'checked' : '' }}> その他</label>
                    </td>
                </tr>

                {{-- メールアドレス入力 --}}
                <tr>
                    <th>メールアドレス <span class="required">※</span></th>
                    <td><input type="text" name="email" placeholder="例: test@example.com" value="{{ old('email') }}">
                        @error('email')
                        <div style=" color:red;">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

                {{-- 電話番号入力（3分割） --}}
                <tr>
                    <th>電話番号 <span class="required">※</span></th>
                    <td class="tel-input" style="display: flex; gap: 8px;">
                        {{-- 電話番号1 --}}
                        <div style="flex:1; display:flex; flex-direction: column;">
                            <input type="text" name="tel1" maxlength="6" placeholder="080" value="{{ old('tel1') }}">
                            @error('tel1')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 電話番号2 --}}
                        <div style="flex:1; display:flex; flex-direction: column;">
                            <input type="text" name="tel2" maxlength="6" placeholder="1234" value="{{ old('tel2') }}">
                            @error('tel2')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 電話番号3 --}}
                        <div style="flex:1; display:flex; flex-direction: column;">
                            <input type="text" name="tel3" maxlength="6" placeholder="5678" value="{{ old('tel3') }}">
                            @error('tel3')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </td>
                </tr>

                {{-- 住所入力 --}}
                <tr>
                    <th>住所 <span class="required">※</span></th>
                    <td><input type="text" name="address" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address') }}">
                        @error('address')
                        <div style=" color:red;">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

                {{-- 建物名入力（任意） --}}
                <tr>
                    <th>建物名</th>
                    <td><input type="text" name="building" placeholder="例: 千駄ヶ谷マンション101" value="{{ old('building') }}"></td>
                </tr>

                {{-- お問い合わせの種類選択 --}}
                <tr>
                    <th>お問い合わせの種類 <span class="required">※</span></th>
                    <td>
                        <select name="category_id">
                            <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>選択してください</option>
                            <option value="1" {{ old('category_id') == 1 ? 'selected' : '' }}>商品のお届けについて</option>
                            <option value="2" {{ old('category_id') == 2 ? 'selected' : '' }}>商品の交換について</option>
                            <option value="3" {{ old('category_id') == 3 ? 'selected' : '' }}>商品トラブル</option>
                            <option value="4" {{ old('category_id') == 4 ? 'selected' : '' }}>ショップへのお問い合わせ</option>
                            <option value="5" {{ old('category_id') == 5 ? 'selected' : '' }}>その他</option>
                        </select>
                        @error('category_id')
                        <div style=" color:red;">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

                {{-- お問い合わせ内容 --}}
                <tr>
                    <th>お問い合わせ内容 <span class="required">※</span></th>
                    <td><textarea name="detail" placeholder="お問い合わせ内容をご記載ください">{{ old('detail') }}</textarea>
                        @error('detail')
                        <div style=" color:red;">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

            </table>

            {{-- 送信ボタン --}}
            <div class="button-area">
                <button type="submit" class="submit-button">確認画面</button>
            </div>
            
        </form>
    </main>
</body>

</html>