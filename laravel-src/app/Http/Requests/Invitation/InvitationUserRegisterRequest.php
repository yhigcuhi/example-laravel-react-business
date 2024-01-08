<?php

namespace App\Http\Requests\Invitation;

use App\Http\Requests\Auth\UserRegisterRequest;
use App\Models\Invitation;
use App\Models\User;
use App\Rules\InvitationToken;
use Carbon\CarbonImmutable;

/**
 * 会員 登録 by 招待 通信
 */
class InvitationUserRegisterRequest extends UserRegisterRequest
{
    /**
     * バリデーション前処理
     */
    protected function prepareForValidation()
    {
        // メアド,招待トークン 補完
        $this->merge([
            'email' => $this->getInvitation()->email, // メアド = 招待の値
            'invitation_token' => $this->route('invitation_token') // 招待トークン = パスパラメーター
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        // 通常 会員登録のルール + 独自ルール
        return [
            ...parent::rules(),
            'invitation_token' => ['required', 'string', new InvitationToken],
        ];
    }
    /**
     * @return User 会員 新規登録値
     */
    public function createOfUser(): User
    {
        // 通常 会員新規登録値 反映 + 独自
        $user = parent::createOfUser();
        $user->forceFill(['email_verified_at' => CarbonImmutable::now()]); // メアド認証日時 反映
        // 結果
        return $user;
    }
    /**
     * @return Invitation 該当の 招待管理
     */
    public function getInvitation(): Invitation
    {
        return Invitation::where('invitation_token', $this->route('invitation_token'))->first();
    }
}
