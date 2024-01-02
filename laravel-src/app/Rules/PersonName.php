<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * 人名 バリデーションルール
 */
class PersonName implements ValidationRule
{
    // 固定メッセージ: 文字数
    const FAIL_OF_MAX_LENGTH = ':attributeは20文字以下で入力してください';
    // 固定メッセージ: 正規表現
    const FAIL_OF_PATTERN = ':attributeは英数字以外で入力してください';

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 文字数チェック
        if (mb_strlen($value) > 20) $fail(self::FAIL_OF_MAX_LENGTH);
        // 正規表現
        if (preg_match('/[A-Za-z0-9０-９]/iu', $value)) $fail(self::FAIL_OF_PATTERN);
    }
}
