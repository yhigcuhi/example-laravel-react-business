<?php

namespace App\Models\QueryBuilders;

use App\Models\UserInvitation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * (View) (ユーザー 事業所) 招待 一覧 検索条件 生成器
 */
readonly class UserInvitationQueryBuilder extends MyQueryBuilder
{
    // 検索項目 一覧
    const COLUMNS = [
        'user_id',
        'invitation_id',
    ];

    /**
     * デフォルトコンストラクタ
     */
    public function __construct()
    {
        // 検索項目一覧 注入
        parent::__construct(self::COLUMNS);
    }

    /**
     * @return Builder 自身への 未承認の 招待一覧 取得
     */
    public static function buildUnVerifeidAllOfMe(): Builder
    {
        // overload = ログインユーザーへの
        return self::buildUnVerifeidAll(Auth::id());
    }

    /**
     * @param int $user_id 指定ユーザー
     * @return Builder 指定ユーザーへの 未承認の 招待一覧 取得
     */
    public static function buildUnVerifeidAll(int $user_id): Builder
    {
        // 指定ユーザーへの 未承認の 招待一覧
        return self::build(['user_id' => $user_id])
            ->whereHas('invitation', fn ($q) => $q->whereNull('verified_at')) // AND 未承認 = 招待の 承認日時 IS NULL
        ;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder EloquentのクエリBuilder初期化
     */
    protected function newQuery(): Builder
    {
        return UserInvitation::query();
    }
}
