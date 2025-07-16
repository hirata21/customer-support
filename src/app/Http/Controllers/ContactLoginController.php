<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class ContactLoginController extends Controller
{

    /**
     * ログイン処理を行うメソッド。
     */
    public function login(LoginRequest $request)
    {
        // バリデーション済みのemailとpasswordのみを取得
        $credentials = $request->only('email', 'password');

        // 認証処理（rememberチェックボックスがオンの場合は保持）
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // セッション固定攻撃対策：セッションIDを再生成
            $request->session()->regenerate();

            // 認証成功 → 管理画面へリダイレクト
            return redirect()->intended('/admin');
        }

        // 認証失敗時：/login にリダイレクトしつつ、エラーメッセージを渡す
        return redirect('/login')
            ->withErrors([
                'email' => 'メールアドレスまたはパスワードが正しくありません。',
            ])
            ->withInput($request->only('email'));
    }
}
