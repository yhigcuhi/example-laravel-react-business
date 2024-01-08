<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 従業員 招待管理 モデル
 */
class StaffInvitation extends Model
{
    use HasFactory;
    // 値変更 可能項目
    protected $fillable = [
        'staff_id', // new のみ
        'invitation_id', // new のみ
    ];
    /* リレーション */
    /**
     * @return BelongsTo (紐づいた) 従業員
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'staff_id');
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
        $this->staff->attachUser($user, $isSave);
        // 結果返却
        return $this;
    }
}
