<?php

namespace App\Services\Invitation;

use App\Models\Invitation;
use App\Models\Staff;
use App\Models\StaffInvitation;
use App\Models\User;
use App\Notifications\StaffInvitationNotification;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * (事業所) 招待管理 ドメイン サービス
 */
class InvitationService
{
    /**
     * 従業員 招待リンク メール送信
     * @param Staff $staff 招待する 従業員
     * @param string $email 宛先 (招待する 従業員 メアド)
     * @return Invitation 送信した後の 招待管理
     */
    public function sendStaffInvitationLink(Staff $staff, string $email): Invitation
    {
        // 前提条件: 必須
        if (!$email) throw new BadRequestHttpException('メアドの指定がありません');
        // 前提条件: 事業所に登録済み (事業所 招待管理ないで ユニーク)
        if ($this->existsInvitation($staff->business_id, $email)) throw new BadRequestHttpException('すでに招待管理に登録されているメアドです');
        // 前提条件: 所属済み(操作可能 事業所 登録済み) ユーザー
        if ($this->existsUserOperatableBusiness($email, $staff->business_id)) throw new BadRequestHttpException('もうすでに事業所操作できるメアドです');

        // 事業所 招待管理 生成
        $invitation = new Invitation([
            'business_id' => $staff->business_id, // 事業所ID = 従業員 と同じ
            'name' => $staff->name, // 画面表示名 = 従業員 名
            'email' => $email, // メアド
        ]);
        // 登録
        $invitation->save();
        // 従業員 招待管理 登録 (招待 - 従業員 紐付け)
        $staff_invitation = new StaffInvitation(['staff_id' => $staff->id, 'invitation_id' => $invitation->id]);
        $staff_invitation->save();

        // 従業員 招待メール送信
        $invitation->notify(new StaffInvitationNotification($invitation));

        // 登録された 招待返却
        return $invitation;
    }

    // TODO: 次 一旦メール送って → ゲストにて アカウント作成できる 招待承認 →　アカウントありで 招待承認 → 更新ロジックの実装の順

    /**
     * @param int $business_id (どこの) 事業所
     * @param string $email (誰への) メアド
     * @return bool true:事業所 招待管理 存在 / false:存在しない
     */
    private function existsInvitation(int $business_id, string $email): bool
    {
        // 事業所 招待管理 存在 判定
        return Invitation::where('business_id', $business_id)->where('email', $email)->exists();
    }

    /**
     * @param string $email (誰) メアド
     * @param int $business_id (どこの) 事業所
     * @return bool true:ユーザー 操作可能 事業所 存在 / false:存在しない
     */
    private function existsUserOperatableBusiness(string $email, int $business_id): bool
    {
        // 該当メアドのユーザー(操作可能 事業所 一覧 付きで) 検索
        $user = User::with('operatableBusinesses')->where('email', $email)->first();
        // 操作可能 事業所 一覧　として存在している 判定
        $operatableBusiness = collect($user?->operatableBusinesses ?? [])->where('business_id', $business_id)->first();
        return !is_null($operatableBusiness);
    }
}
