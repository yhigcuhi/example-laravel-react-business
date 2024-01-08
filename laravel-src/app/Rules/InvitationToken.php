<?php

namespace App\Rules;

use App\Models\Invitation;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * 招待コード バリデーションルール
 */
class InvitationToken implements ValidationRule
{
    // 固定メッセージ: 存在
    const FAIL_OF_EXISTS = ':attributeは有効期限が切れているまたは、存在しないです.内容をご確認ください.';
    // 固定メッセージ: 有効期限切れ
    const FAIL_OF_EXPIRED = ':attributeは有効期限が切れているまたは、存在しないです.内容をご確認ください.';

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 該当の招待管理検索
        $invitation = Invitation::where('invitation_token', $value)->first();
        // 存在チェック
        if (!$invitation) $fail(self::FAIL_OF_EXISTS);
        // 有効期限切れ
        if ($invitation->isExpired()) $fail(self::FAIL_OF_EXPIRED);
    }
}
