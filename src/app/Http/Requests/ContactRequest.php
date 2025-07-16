<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * ユーザー登録フォームの入力バリデーションを担当するリクエストクラス
 */
class ContactRequest extends FormRequest
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
            'last_name'  => ['required', 'string', 'max:255'],      // 姓は必須かつ文字列・最大255文字
            'first_name' => ['required', 'string', 'max:255'],      // 名は必須かつ文字列・最大255文字
            'gender'     => ['required', 'in:1,2,3'],               // 性別は必須・指定された値のいずれか
            'email'      => ['required', 'email', 'max:255'],       // メールは必須かつメール形式・最大255文字
            // 電話番号は3つに分割、各パーツは必須・数字のみ・1～5桁
            'tel1' => ['required', 'digits_between:1,5', 'regex:/^[0-9]+$/'],
            'tel2' => ['required', 'digits_between:1,5', 'regex:/^[0-9]+$/'],
            'tel3' => ['required', 'digits_between:1,5', 'regex:/^[0-9]+$/'],
            'address'    => ['required', 'string', 'max:255'],      // 住所は必須かつ文字列・最大255文字
            'building'   => ['nullable', 'string', 'max:255'],      // 建物名は任意・文字列・最大255文字
            'category_id'   => ['required', 'string'],              // お問い合わせ種類は必須かつ文字列
            'detail'    => ['required', 'string', 'max:130'],       // お問い合わせ内容は必須・文字列・最大130文字
        ];
    }


    /**
     * バリデーションエラー時に表示するメッセージを定義します。
     */
    public function messages()
    {
        return [
            'last_name.required' => '姓を入力してください',
            'first_name.required' => '名を入力してください',
            'gender.required' => '性別を選択してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'tel1.required' => '電話番号を入力してください',
            'tel2.required' => '電話番号を入力してください',
            'tel3.required' => '電話番号を入力してください',
            'tel1.digits_between' => '電話番号は5桁までの数字で入力してください。',
            'tel2.digits_between' => '電話番号は5桁までの数字で入力してください。',
            'tel3.digits_between' => '電話番号は5桁までの数字で入力してください.',
            'tel1.regex' => '電話番号は5桁までの数字で入力してください。',
            'tel2.regex' => '電話番号は5桁までの数字で入力してください。',
            'tel3.regex' => '電話番号は5桁までの数字で入力してください。',
            'address.required' => '住所を入力してください',
            'category_id.required' => 'お問い合わせの種類を選択してください',
            'detail.required' => 'お問い合わせ内容を入力してください',
            'detail.max' => 'お問い合わせ内容は120文字以内で入力してください。',
        ];
    }
}
