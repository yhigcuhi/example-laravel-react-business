<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * (View) (ユーザー 事業所) 招待 一覧 モデル
 */
class UserInvitation extends Model
{
    protected $table = 'view_user_invitations';
    // 登録更新できないフィールド → view のため全て
    protected $guard = [
        'user_id',
        'invitation_id'
    ];
    /* リレーション */
    /**
     * @return BelongsTo 招待
     */
    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class, 'invitation_id');
    }

    /**
     * @return HasOneThrough 招待 事業所
     */
    public function business(): HasOneThrough
    {
        return $this->hasOneThrough(Business::class, Invitation::class, 'id', 'id', 'invitation_id', 'business_id');
    }
}
