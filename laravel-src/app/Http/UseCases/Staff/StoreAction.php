<?php

namespace App\UseCases\Staff;

use App\Models\Staff;

/**
 * ユースケース : 従業員登録
 */
class StoreAction
{
    /**
     * アクション 実行
     * @param Staff $staff 登録値
     * @param string $email メアドの登録値
     */
    public function __invoke(Staff $staff, string $email): Staff
    {
        // 前提条件
        if ($staff->id) return $staff; //　登録済み → 何もしない

        // 従業員 新規追加
        $staff->save();

        // メアド指定あり → 事業所 招待メール追加 TODO:今後、仕様.mdの招待参照
        // if ($request->input('email'))

        // 登録結果
        return $staff;
    }
}
