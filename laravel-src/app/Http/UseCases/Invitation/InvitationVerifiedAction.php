<?php

namespace App\Http\UseCases\Invitation;
;

use App\Models\Invitation;
use App\Models\StaffInvitation;
use Illuminate\Support\Facades\Auth;

/**
 * ユースケース : 招待 承認アクション
 */
class InvitationVerifiedAction
{
    /**
     * アクション 実行
     * @param Invitation $invitation 承認された 招待
     */
    public function __invoke(Invitation $invitation): Invitation
    {
        // 前提条件
        if (!$invitation) return $invitation; // 存在しない →　何もしない
        if (!$invitation->id) return $invitation; // 未登録 →　何もしない

        // 関連する 従業員 招待管理 検索
        $staff_invitation = $this->findStaffInvitation($invitation);
        // 関連する 従業員 の 会員紐付け 更新 (ログイン者)
        if ($staff_invitation) $staff_invitation->attachUser(Auth::user());
        // 招待承認
        return $invitation->verified();
    }

    /**
     * @param Invitation $invitation 招待管理
     * @return StaffInvitation|null 関連する 従業員 招待
     */
    private function findStaffInvitation(Invitation $invitation): ?StaffInvitation
    {
        return StaffInvitation::with('staff')->where('invitation_id', $invitation->id)->first();
    }
}
