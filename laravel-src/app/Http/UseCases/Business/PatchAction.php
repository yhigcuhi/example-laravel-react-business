<?php

namespace App\UseCases\Business;

use App\Models\Business;

/**
 * ユースケース : 事業所更新
 */
class PatchAction
{
    /**
     * アクション 実行
     * @param Business $business 登録値
     */
    public function __invoke(Business $business): Business
    {
        // 前提条件
        if (!$business->id) return $business; //　未登録 →　何もしない

        // 更新
        $business->save();

        // 登録結果
        return $business;
    }
}
