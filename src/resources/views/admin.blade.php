<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面</title>
    {{-- リセットCSS（Sanitize） --}}
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    {{-- 管理画面用スタイル --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    {{-- モーダルのスタイル --}}
    <style>
        .modal {
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
            height: 80vh;
            overflow-y: auto;
            position: relative;
            box-sizing: border-box;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .modal-footer {
            text-align: center;
            margin-top: 50px;
        }

        .modal-content {
            padding-bottom: 10px;
        }

        .btn-delete {
            background-color: red;
            color: white;
            padding: 10px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-detail {
            color: blue;
            cursor: pointer;
            text-decoration: underline;
        }

        .modal-body {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .modal-row {
            display: flex;
            align-items: center;
        }

        .modal-row label {
            width: 160px;
            font-weight: bold;
            text-align: left;
        }

        .modal-row span {
            flex: 1;
            text-align: left;
        }
    </style>
</head>

</head>

<body>
    <header class="header">
        <h1 class="logo">FashionablyLate</h1>
        {{-- ログアウトボタン --}}
        <div class="header-right">
            <a href="/login" class="header-button">logout</a>
        </div>
    </header>

    {{-- メインコンテンツ --}}
    <div class="container">
        <h2 class="subtitle">Admin</h2>

        {{-- 検索フォーム --}}
        <form method="get" action="{{ route('admin') }}" class="search-form">
            <input type="text" name="keyword" class="form-keyword" placeholder="名前やメールアドレスを入力してください">

            {{-- 性別セレクト --}}
            <select name="gender" class="form-gender">
                <option value="">性別</option>
                <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
                <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
                <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
            </select>

            {{-- カテゴリセレクト --}}
            <select name="category_id" class="form-category">
                <option value="">お問い合わせの種類</option>
                <option value="1" {{ request('category_id') == '1' ? 'selected' : '' }}>商品のお届けについて</option>
                <option value="2" {{ request('category_id') == '2' ? 'selected' : '' }}>商品の交換について</option>
                <option value="3" {{ request('category_id') == '3' ? 'selected' : '' }}>商品トラブル</option>
                <option value="4" {{ request('category_id') == '4' ? 'selected' : '' }}>ショップへのお問い合わせ</option>
                <option value="5" {{ request('category_id') == '5' ? 'selected' : '' }}>その他</option>
            </select>

            {{-- 日付 --}}
            <input type="date" name="date" value="{{ request('date') }}" class="form-date">

            {{-- 検索・リセットボタン --}}
            <button type="submit" class="btn-search">検索</button>
            <a href="{{ route('admin') }}" class="btn-reset">リセット</a>
        </form>

        {{-- エクスポートボタンとページネーション --}}
        <div class="table-controls">
            <a href="{{ route('admin.export', request()->query()) }}" class="btn-export">エクスポート</a>
            <div class="pagination-wrapper">
                {{ $contacts->appends(request()->query())->links() }}
            </div>
        </div>

        {{-- データテーブル --}}
        <table class="data-table">
            <thead>
                <tr>
                    <th>お名前</th>
                    <th>性別</th>
                    <th>メールアドレス</th>
                    <th>お問い合わせの種類</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                <tr>
                    <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                    <td>{{ $contact->gender_label }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->category_label }}</td>
                    <td>
                        {{-- 詳細モーダルを開くボタン --}}
                        <button
                            class="btn-detail"
                            onclick="openModal(this)"
                            data-id="{{ $contact->id }}"
                            data-name="{{ $contact->first_name }} {{ $contact->last_name }}"
                            data-gender="{{ $contact->gender_label }}"
                            data-email="{{ $contact->email }}"
                            data-tel="{{ $contact->tel }}"
                            data-address="{{ $contact->address }}"
                            data-building="{{ $contact->building }}"
                            data-category="{{ $contact->category_label }}"
                            data-detail="{{ $contact->detail }}"
                            data-created="{{ $contact->created_at->format('Y-m-d') }}">
                            詳細
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- 詳細モーダル --}}
    <div id="detailModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" id="modalClose">&times;</span>

            <div class="modal-body">
                {{-- 各項目 --}}
                <div class="modal-row"><label>お名前:</label><span id="modalName"></span></div>
                <div class="modal-row"><label>性別:</label><span id="modalGender"></span></div>
                <div class="modal-row"><label>メールアドレス:</label><span id="modalEmail"></span></div>
                <div class="modal-row"><label>電話番号:</label><span id="modalPhone"></span></div>
                <div class="modal-row"><label>住所:</label><span id="modalAddress"></span></div>
                <div class="modal-row"><label>建物名:</label><span id="modalBuilding"></span></div>
                <div class="modal-row"><label>お問い合わせの種類:</label><span id="modalCategory"></span></div>
                <div class="modal-row"><label>お問い合わせ内容:</label><span id="modalDetail"></span></div>
            </div>

            {{-- 削除ボタン --}}
            <div class="modal-footer">
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">削除</button>
                </form>
            </div>
        </div>
    </div>

    {{-- モーダル制御用JavaScript --}}
    <script>
        function openModal(button) {
            document.getElementById('modalName').textContent = button.dataset.name;
            document.getElementById('modalGender').textContent = button.dataset.gender;
            document.getElementById('modalEmail').textContent = button.dataset.email;
            document.getElementById('modalPhone').textContent = button.dataset.tel;
            document.getElementById('modalAddress').textContent = button.dataset.address;
            document.getElementById('modalBuilding').textContent = button.dataset.building;
            document.getElementById('modalCategory').textContent = button.dataset.category;
            document.getElementById('modalDetail').textContent = button.dataset.detail;

            document.getElementById('deleteForm').action = `/admin/contacts/${button.dataset.id}`;

            document.getElementById('detailModal').style.display = 'flex';
        }

        document.getElementById('modalClose').addEventListener('click', () => {
            document.getElementById('detailModal').style.display = 'none';
        });

        window.addEventListener('click', (e) => {
            const modal = document.getElementById('detailModal');
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>
</body>

</html>