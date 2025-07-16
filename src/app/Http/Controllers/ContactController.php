<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    /**
     * 入力フォームの確認画面表示処理
     * バリデーション済みのデータを確認画面ビューに渡す
     */
    public function store(ContactRequest $request)
    {
        // バリデーション済みデータを取得
        $validated = $request->validated();

        // 確認画面にデータを渡して表示
        return view('contact.confirm', compact('validated'));
    }

    /**
     * 入力フォームの表示処理
     */
    public function index()
    {
        // 入力フォームのビューを返す
        return view('index');
    }
}
