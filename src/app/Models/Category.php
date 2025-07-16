<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // ホワイトリストで代入可能なカラム
    protected $fillable = [
        'content',  // カテゴリの名前や説明（例：商品の交換についてなど）
    ];

    // Contact モデルとのリレーション定義（1対多）
    public function contacts()
    {
        // 1つのカテゴリに複数のお問い合わせ（Contact）が紐づく
        return $this->hasMany(Contact::class);
    }
}
