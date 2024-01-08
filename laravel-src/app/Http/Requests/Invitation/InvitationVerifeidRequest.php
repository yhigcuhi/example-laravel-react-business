<?php

namespace App\Http\Requests\Invitation;

use App\Models\Invitation;
use App\Rules\InvitationToken;
use Illuminate\Foundation\Http\FormRequest;

/**
 * 招待承認 通信
 */
class InvitationVerifeidRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'string', new InvitationToken],
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
