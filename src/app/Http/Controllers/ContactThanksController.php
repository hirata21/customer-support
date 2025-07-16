<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactThanksController extends Controller
{

    /**
     * お問い合わせ完了画面の表示
     *
     * フォーム送信完了後に表示するサンクスページを返します。
     */
    public function store()
    {
        // thanks.blade.php ビューを表示
        return view('thanks');
    }
}
