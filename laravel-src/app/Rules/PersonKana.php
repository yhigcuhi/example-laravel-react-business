<?php

namespace App\Rules;

use Closure;

/**
 * 人名 フリガナ バリデーションルール
 */
class PersonKana extends PersonName
{
    // 固定メッセージ: 正規表現
    const FAIL_OF_PATTERN = ':attributeは全角カタカナで入力してください';
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // super 実行
        parent::validate($attribute, $value, $fail);
        // 正規表現 実行
        if (!preg_match('/^[ァ-ンヴー]+$/iu', $value)) $fail(self::FAIL_OF_PATTERN);
    }
}
