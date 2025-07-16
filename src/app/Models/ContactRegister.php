<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRegister extends Model
{
    use HasFactory;

    // このモデルが利用するテーブル名を明示
    protected $table = 'users';

    // ホワイトリストで代入可能なカラム
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
    ];
}
