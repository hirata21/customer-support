<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // このモデルが利用するテーブル名を明示
    protected $table = 'contacts';

    // ホワイトリストで代入可能なカラム
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'email',
        'inquiry_type',
        'created_at',
        'updated_at'
    ];

    // カテゴリとのリレーション
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // アクセサ：性別の数値をラベル（文字列）に変換
    public function getGenderLabelAttribute()
    {
        switch ($this->gender) {
            case 1:
                return '男性';
            case 2:
                return '女性';
            case 3:
                return 'その他';
            default:
                return '不明';
        }
    }

    // アクセサ：カテゴリIDを対応するカテゴリ名に変換
    public function getCategoryLabelAttribute()
    {
        switch ($this->category_id) {
            case 1:
                return '商品のお届けについて';
            case 2:
                return '商品の交換について';
            case 3:
                return '商品トラブル';
            case 4:
                return 'ショップへのお問い合わせ';
            case 5:
                return 'その他';
            default:
                return '不明';
        }
    }
}
