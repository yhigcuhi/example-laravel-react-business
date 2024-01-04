<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * (所属)スタッフ モデル
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
        'last_kana',
        'first_kana',
    ];
    // 登録更新できないフィールド
    protected $guard = [
        'name',
        'kana',
        'email',
    ];
    // シリアライズ追加
    protected $appends = [
        'name',
        'kana',
        'email',
    ];
    /* リレーション */
    /**
     * @return BelongsTo (紐づいた) ユーザー
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /* フィールドアクセッサ */
    /**
     * @return string 名前
     */
    public function getNameAttribute(): string
    {
        // 名前 = 姓 + 半角スペース + 名
        return $this->last_name ? "$this->last_name $this->first_name" : '';
    }
    /**
     * @return string フリガナ
     */
    public function getKanaAttribute(): string
    {
        // 名前 = セイ + 半角スペース + メイ
        return $this->last_kana ? "$this->last_kana $this->first_kana" : '';
    }

    /**
     * @return string|null メアド
     */
    public function getEmailAttribute(): ?string
    {
        return ($this->user ?? new User(['email' => null]))->email;
    }
}
