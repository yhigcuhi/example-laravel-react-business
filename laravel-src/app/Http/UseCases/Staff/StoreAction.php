<?php

namespace App\Http\UseCases\Staff;

use App\Models\Staff;
use App\Services\Invitation\InvitationService;

/**
 * ユースケース : 従業員登録
 */
class StoreAction
{

    // ドメインサービス
    private readonly InvitationService $service;
    /* CDI */
    public function __construct(InvitationService $service) {
        $this->service = $service;
    }

    /**
     * アクション 実行
     * @param Staff $staff 登録値
     * @param string|null $email メアドの登録値
     */
    public function __invoke(Staff $staff, ?string $email = ''): Staff
    {
        // 前提条件
        if ($staff->id) return $staff; //　登録済み → 何もしない

        // 従業員 新規追加
        $staff->save();

        // メアド指定あり
        if ($email) $this->service->sendStaffInvitationLink($staff, $email); //　従業員 招待 メール送信

        // 登録結果
        return $staff;
    }
}
