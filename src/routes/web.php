<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactConfirmController;
use App\Http\Controllers\ContactThanksController;
use App\Http\Controllers\ContactRegisterController;
use App\Http\Controllers\ContactLoginController;
use App\Http\Controllers\ContactAdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/* -----------------------------
| フォーム入力・確認・完了
|------------------------------*/

// お問い合わせフォーム（入力画面） [GET]
Route::get('/', [ContactController::class, 'index'])->name('contact.index');

// 入力内容の確認画面 [POST]
Route::post('/confirm', [ContactConfirmController::class, 'confirm'])->name('confirm');

// 送信完了（サンクス）画面 [GET]
Route::get('/thanks', [ContactThanksController::class, 'store'])->name('thanks');


/* -----------------------------
| ユーザー登録
|------------------------------*/

// 登録フォーム表示 [GET]
Route::get('/register', [ContactRegisterController::class, 'show'])->name('register.form');

// ユーザー登録処理 [POST]
Route::post('/register', [ContactRegisterController::class, 'register'])->name('register');


/* -----------------------------
| ログイン
|------------------------------*/

// ログインフォーム表示 [GET]
Route::get('/login', function () {
    return view('login');
})->name('login');

// ログイン処理 [POST]
Route::post('/login', [ContactLoginController::class, 'login'])->name('login');


/* -----------------------------
| 管理画面（要ログイン）
|------------------------------*/

// 管理画面トップ（一覧） [GET]
Route::get('/admin', [ContactAdminController::class, 'index'])->middleware('auth')->name('admin');

// 個別詳細表示 [GET]
Route::get('/admin/contacts/{id}', [ContactAdminController::class, 'show'])->name('admin.detail');

// データ削除処理 [DELETE]
Route::delete('/admin/contacts/{id}', [ContactAdminController::class, 'destroy'])->name('admin.destroy');

// データのCSVエクスポート [GET]
Route::get('/admin/export', [ContactAdminController::class, 'export'])->name('admin.export');
