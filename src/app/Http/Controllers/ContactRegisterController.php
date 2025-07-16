<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\ContactRegister;
use Illuminate\Support\Facades\Hash;

class ContactRegisterController extends Controller
{
    /**
     * 管理者登録フォームを表示する
     */
    public function show()
    {
        // 登録フォームのビュー（resources/views/register.blade.php）を返す
        return view('register');
    }

    /**
     * 登録フォームから送信されたデータを処理し、管理者を新規登録する
     */
    public function register(RegisterRequest $request)
    {
        // バリデーション済みの入力データを取得
        $data = $request->validated();

        // データベースに新しい管理者レコードを作成
        ContactRegister::create([
            'name'     => $data['name'],                    // 管理者の名前
            'email'    => $data['email'],                   // 管理者のメールアドレス
            'password' => Hash::make($data['password']),    // パスワードはハッシュ化して保存
        ]);

        // 登録完了メッセージをセッションに保存してフォーム画面にリダイレクト
        return redirect()
        ->route('register.form')    // `web.php`で定義された 'register.form' ルートへ
        ->with('success', '管理者登録が完了しました');
    }
}
