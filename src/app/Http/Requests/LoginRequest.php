<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * ユーザー登録フォームの入力バリデーションを担当するリクエストクラス
 */
class LoginRequest extends FormRequest
{
    /**
     * このリクエストを実行するユーザーに認可（権限）があるかを判定します。
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * バリデーションルールを定義します。
     *
     * 各フォーム項目に対して、入力が必須であることや形式を指定します。
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email'],       // メールアドレスは必須かつ正しい形式
            'password' => ['required', 'string'],   // パスワードは必須かつ文字列
        ];
    }


    /**
     * バリデーションエラー時に表示するメッセージを定義します。
     */
    public function messages()
    {
        return [
            'name.required' => 'お名前を入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスは「ユーザ名@ドメイン」形式で入力してください',
            'password.required' => 'パスワードを入力してください',
        ];
    }


    /**
     * 入力情報を使って認証を試みます。
     * 認証失敗時はValidationExceptionをスローします。
     */
    public function authenticate()
    {
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => __('認証に失敗しました。'),
            ]);
        }
    }

}
