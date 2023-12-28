<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * (システムログイン) ユーザー
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    // 登録更新できないフィールド
    protected $guard = [
        'operating_business',
    ];
    // シリアライズ追加
    protected $appends = [
        'operating_business',
    ];

    /* リレーション */
    /**
     * @return HasMany ユーザー 操作 事業所 一覧
     */
    public function operatableBusinesses(): HasMany
    {
        return $this->hasMany(UserOperatableBusiness::class, 'user_id');
    }

    /* ドメイン関数 */
    /**
     * 操作中へ
     * @param int $business_id 操作中にする事業所ID
     * @return self 更新後自身
     */
    public function operating(int $business_id): self
    {
        // 最新取得
        $operation_businesses = collect($this->operatableBusinesses()->get());
        // 操作中へ (それ以外の事業所 解除)
        $operation_businesses->each(function(UserOperatableBusiness $business) use($business_id) {
            if ($business->business_id == $business_id) $business->operating(); // 操作中
            else $business->unoperating(); // それ以外 解除
        });
        // 更新後自身
        return $this;
    }

    /* ドメイン関数 */
    /**
     * @return UserOperatableBusiness|null 操作中の事業所
     */
    public function getOperatingBusinessAttribute(): ?UserOperatableBusiness
    {
        return $this->operatableBusinesses()->with('business')->firstWhere('is_operating', true);
    }
}
