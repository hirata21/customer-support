<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactConfirm;
use App\Http\Requests\ContactRequest;

class ContactConfirmController extends Controller
{
    /**
     * 入力内容の確認・送信処理
     */
    public function confirm(ContactRequest $request)
    {
        // バリデーション済みのデータを取得
        $data = $request->validated();

        // フルネームを生成（姓＋名）
        $data['name'] = trim(($data['last_name'] ?? '') . ' ' . ($data['first_name'] ?? ''));

        // 電話番号を1つの文字列にまとめる
        $data['tel'] = implode('', [
            $data['tel1'] ?? '',
            $data['tel2'] ?? '',
            $data['tel3'] ?? ''
        ]);

        // カテゴリIDと名称の対応表
        $categoryNames = [
            1 => '商品のお届けについて',
            2 => '商品の交換について',
            3 => '商品トラブル',
            4 => 'ショップへのお問い合わせ',
            5 => 'その他',
        ];

        // カテゴリ名をデータに追加
        $data['category_name'] = $categoryNames[$data['category_id']] ?? '';

        // ボタンアクションを取得（submit または back）
        $action = $request->input('action');

        // 「送信」が押された場合：データベースに保存してサンクスページへリダイレクト
        if ($action === 'submit') {
            $contact = new \App\Models\Contact();
            $contact->last_name = $data['last_name'];
            $contact->first_name = $data['first_name'];
            $contact->gender = (int)$data['gender'];
            $contact->email = $data['email'];
            $contact->tel = $data['tel'];
            $contact->address = $data['address'];
            $contact->building = $data['building'] ?? null;
            $contact->category_id = (int)$data['category_id'];
            $contact->detail = $data['detail'];
            $contact->save();

            // 保存成功後、サンクスページへリダイレクト
            return redirect()->route('thanks');
        }

        // 「修正」が押された場合：入力画面に戻り、入力内容を保持
        if ($action === 'back') {
            return redirect()->route('contact.index')->withInput($data);
        }


        // 確認画面へデータを渡して表示
        return view('confirm', ['inputs' => $data]);
    }

    /**
     * 入力画面の表示
     */
    public function form()
    {
        return view('index'); // 入力画面のBladeファイル名
    }

    /**
     * サンクスページの表示
     */
    public function thanks()
    {
        return view('thanks'); // 完了画面のBladeファイル名
    }
}
