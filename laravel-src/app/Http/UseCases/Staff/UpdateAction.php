<?php

namespace App\Http\UseCases\Staff;

use App\Models\Staff;

/**
 * ユースケース : 従業員更新
 */
class UpdateAction
{
    /**
     * アクション 実行
     * @param Staff $staff 更新値
     * @param string|null $email メアドの更新値
     */
    public function __invoke(Staff $staff, ?string $email = ''): Staff
    {
        // 前提条件
        if (!$staff->id) return $staff; // 未登録 → 何もしない

        // 従業員 新規追加
        $staff->save();

        // 従業員のアカウント紐済み →　後続 アカウント招待処理しない
        if ($staff->user_id) return $staff;
        // メアド指定あり → 事業所 招待メール追加 TODO:今後、仕様.mdの招待参照
        // else if ($request->input('email'))

        // 登録結果
        return $staff;
    }
}
