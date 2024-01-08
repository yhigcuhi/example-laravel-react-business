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

    /* 外部参照可能: ドメインメソッド */
    /**
     * ユーザー紐付け
     * @param User $user 紐づけるユーザー
     * @param bool $isSave true:保存処理実行 / false: 保存処理しない
     */
    public function attachUser(User $user, bool $isSave = true): self
    {
        // (紐づいた) 従業員 に ユーザー紐付け
        $this->fill(['user_id' => $user->id]);
        // 永続化
        if ($isSave) $this->save();
        // 結果返却
        return $this;
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
