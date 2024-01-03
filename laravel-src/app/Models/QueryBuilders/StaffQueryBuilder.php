<?php

namespace App\Models\QueryBuilders;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Builder;

/**
 * 従業員 検索条件 生成器
 */
readonly class StaffQueryBuilder extends MyQueryBuilder
{
    // 検索項目 一覧
    const COLUMNS = [
        'business_id',
        'user_id',
        'last_name',
        'first_name',
        'last_kana',
        'first_kana',
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
     * @return \Illuminate\Database\Eloquent\Builder EloquentのクエリBuilder初期化
     */
    protected function newQuery(): Builder
    {
        return Staff::query();
    }
}
