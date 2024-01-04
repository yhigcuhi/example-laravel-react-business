<?php

namespace App\Http\UseCases\Staff;

use App\Models\QueryBuilders\StaffQueryBuilder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * ユースケース : 従業員検索 アクション
 */
class SearchAction
{
    /**
     * アクション 実行
     * @param int $business_id 事業所ID 必須
     * @param array|null $conditions その他 検索条件
     * @param int|null $paginate ページ数
     */
    public function __invoke(int $business_id, ?array $conditions = [], ?int $paginate = 20): LengthAwarePaginator|Collection
    {
        // 従業員 検索条件生成 (作成順)
        $query = StaffQueryBuilder::build($conditions)->orderBy('id')->where('business_id', $business_id);
        // 検索実行 (ページ数指定 = その数)
        return $paginate ? $query->paginate($paginate) : $query->get();
    }
}
