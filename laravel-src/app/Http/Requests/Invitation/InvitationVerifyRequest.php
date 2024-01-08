<?php

namespace App\Http\Requests\Invitation;

use App\Models\Invitation;
use App\Rules\InvitationToken;
use Illuminate\Foundation\Http\FormRequest;

/**
 * 招待通知 確認 登録通信
 */
class InvitationVerifyRequest extends FormRequest
{
    // エラー リダイレクト先
    protected $redirectRoute = 'invitation.verify.error';

    /**
     * バリデーション前処理
     */
    protected function prepareForValidation()
    {
        // 招待トークン 補完
        $this->merge(['invitation_token' => $this->route('invitation_token')]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'invitation_token' => ['required', 'string', new InvitationToken],
        ];
    }

    /**
     * @return Invitation 該当の 招待管理
     */
    public function getInvitation(): Invitation
    {
        return Invitation::with(['user'])->where('invitation_token', $this->validated('invitation_token'))->first();
    }
}
