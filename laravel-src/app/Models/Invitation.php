<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * (事業所) 招待管理 (事業所 - 従業員, 士業) モデル
 */
class Invitation extends Model
{
    // メール送信などの通知も利用
    use HasFactory, Notifiable;
    // 値変更 可能項目
    protected $fillable = [
        'business_id',
        'name',
        'email',
    ];
    // キャスト
    protected $casts = [
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * ライフサイクルイベント フック
     */
    public static function boot()
    {
        // 継承内容実施
        parent::boot();
        // 新規登録 前処理
        self::creating(function ($model) {
            // 招待 トークン発行
            $model->invitation_token = self::createNewToken();
        });
    }
    /* リレーション */
    /**
     * @return BelongsTo (紐づいた) 事業所
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    /**
     * @return HasOneThrough (該当) ユーザー (見つからない:未登録 アカウントの招待)
     */
    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, UserInvitation::class, 'invitation_id', 'id', 'id', 'user_id');
    }

    /* 外部参照可能: ドメインメソッド */
    /**
     * @return bool true:有効期限切れ/false:それ以外
     */
    public function isExpired(): bool
    {
        // config/auth.php から 招待の有効期限 秒数 取得
        $expire = config('auth.invitation.expire');
        // 有効期限日時 = 更新日時 の 招待の有効期限 秒数後
        $expiredAt = Carbon::parse($this->updated_at)->addSeconds((int) $expire);
        // 実行日時 > 有効期限日時 → true
        return Carbon::now()->gt($expiredAt);
    }
    /**
     * 招待承認
     * @param bool $isSave true:保存処理実行 / false: 保存処理しない
     */
    public function verified(bool $isSave = true): self
    {
        // 前提条件
        if (!is_null($this->verified_at)) return $this; // 承認ずみ 何もしない
        if ($this->isExpired()) return $this; // 有効期限切れ 何もしない

        // 招待承認日時 記録
        $this->forceFill(['verified_at' => CarbonImmutable::now()]);
        // ユーザー 操作可能 事業所 追加 (登録済みの場合は更新)
        $operatableBusiness = $this->findOperatableBusiness() ?? new UserOperatableBusiness(['user_id' => $this->user->id, 'business_id' => $this->business_id]);

        // 永続化
        if ($isSave) {
            $this->save();
            $operatableBusiness->save();
        }
        // 承認後 返却
        return $this;
    }

    /**
     * (未承認時のみ) トークン 再発行
     * @param bool $isSave true:保存処理実行 / false: 保存処理しない
     */
    public function changeToken(bool $isSave = true): self
    {
        // 前提条件
        if (is_null($this->id)) return $this; // 未登録 何もしない
        if (!is_null($this->verified_at)) return $this; // 承認ずみ 何もしない
        // トークン再発行
        $this->forceFill(['invitation_token' => self::createNewToken()]);

        // 永続化
        if ($isSave) $this->save();
        // 返却
        return $this;
    }

    /* 内部参照可能: ドメインメソッド */
    /**
     * @return string トークン新規発行
     */
    private static function createNewToken(): string
    {
        // PasswordBrokerManager->createTokenRepository 同様 hashキーを利用
        $hash_key = config('app.key');
        // hashキー 補完
        if (str_starts_with($hash_key, 'base64:')) {
            $hash_key = base64_decode(substr($hash_key, 7));
        }

        // トークン = ハッシュキーを利用した ランダム文字列 (有効期限は文字列に含めない)
        return hash_hmac('sha256', Str::random(40), $hash_key);
    }

    /**
     * @return UserOperatableBusiness|null (該当) ユーザーの ユーザー 操作可能 事業所 By 招待 事業所の検索
     */
    private function findOperatableBusiness(): ?UserOperatableBusiness
    {
        // 該当ユーザー 検索
        $user = $this->user;
        // 該当ユーザー未登録 → 見つからない
        if (!$user) return null;

        // ユーザー 操作可能 事業所 から 招待 事業所の検索
        return $user->operatableBusinesses()->where('business_id', $this->business_id)->first();
    }
}
