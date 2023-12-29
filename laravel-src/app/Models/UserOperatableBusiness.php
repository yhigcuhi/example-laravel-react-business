<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * (システムログイン) ユーザー 操作可能 事業所 モデル TODO:イベントでの実装: 従業員登録されたら レコード作成の項目 (ジョブカンでいうログイン連携)
 */
class UserOperatableBusiness extends Model
{
    use HasFactory;
    // テーブル名
    protected $table = 'user_operatable_businesses';
    // 値変更 可能項目
    protected $fillable = [
        'business_id',
        'is_operating',
    ];
    // フィールドキャスト
    protected $casts = [
        'is_operating' => 'boolean'
    ];

    /* リレーション */
    /**
     * @return BelongsTo 事業所
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    /* ドメイン関数 */
    /**
     * 操作中へ
     * @return self 更新後自身
     */
    public function operating(): self
    {
        // 操作中へ 更新
        $this->fill(['is_operating' => true])->save();
        return $this;
    }
    /**
     * 操作中 解除
     * @return self 更新後自身
     */
    public function unoperating(): self
    {
        // 操作中 解除
        $this->fill(['is_operating' => false])->save();
        return $this;
    }
}
