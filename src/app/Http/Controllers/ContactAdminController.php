<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactAdminController extends Controller
{

    /**
     * 管理画面トップ（一覧表示・検索）
     */
    public function index(Request $request)
    {

        // 検索フィルター処理
        $query = Contact::query();

        // キーワード検索（名前・フルネーム・メール）
        if ($request->keyword) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->keyword}%")
                    ->orWhere('last_name', 'like', "%{$request->keyword}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$request->keyword}%"])
                    ->orWhere('email', 'like', "%{$request->keyword}%");
            });
        }


        // 性別で絞り込み（完全一致）
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // カテゴリで絞り込み（完全一致）
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 登録日で絞り込み（完全一致）
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // ページネーション（1ページあたり7件）＋クエリ引き継ぎ
        $contacts = $query->paginate(7)->appends($request->query());

        return view('admin', ['contacts' => $contacts]);

    }


    /**
     * 詳細表示（未使用または個別ビューが必要な場合）
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.show', compact('contact'));
    }


    /**
     * 削除処理
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin')->with('success', 'お問い合わせを削除しました');
    }


    /**
     * CSVエクスポート
     */
    public function export(Request $request): StreamedResponse
    {
        // 検索条件に基づいたデータ取得
        $query = Contact::query();

        // キーワード検索（名前・メール）
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        // 性別・カテゴリ・日付フィルター
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->get();

        // CSVヘッダー設定
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="contacts.csv"',
        ];

        // CSV列名（日本語）
        $columns = ['名前', '性別', 'メールアドレス', '電話番号', '住所', '建物名', 'カテゴリ', '内容', '登録日'];

        // CSV出力のレスポンスを返す
        return response()->stream(function () use ($contacts, $columns) {
            $handle = fopen('php://output', 'w');

            // ヘッダー行
            fputcsv($handle, $columns);

            // データ行を出力
            foreach ($contacts as $contact) {
                fputcsv($handle, [
                    $contact->first_name . ' ' . $contact->last_name,
                    $contact->gender_label,
                    $contact->email,
                    $contact->tel,
                    $contact->address,
                    $contact->building,
                    $contact->category_label,
                    $contact->detail,
                    $contact->created_at->format('Y-m-d'),
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}