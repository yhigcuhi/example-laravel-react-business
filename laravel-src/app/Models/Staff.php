<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * (所属)スタッフ モデル TODO:事業所の中でユーザーはユニーク serviceで実装？
 */
class Staff extends Model
{
    use HasFactory;
    // テーブル名
    protected $table = 'staff';
    // 値変更 可能項目
    protected $fillable = [
        'business_id',
        'user_id',
        'last_name',
        'first_name',
    ];
    // 登録更新できないフィールド
    protected $guard = [
        'name',
    ];
    // シリアライズ追加
    protected $appends = [
        'name',
    ];

    /* フィールドアクセッサ */
    /**
     * @return string 名前
     */
    public function getNameAttribute(): string
    {
        // 名前 = 姓 + 半角スペース + 名
        return "$this->last_name $this->first_name";
    }
}
