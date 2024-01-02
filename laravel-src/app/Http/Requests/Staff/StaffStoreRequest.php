<?php

namespace App\Http\Requests\Staff;

use App\Models\Staff;
use App\Models\User;
use App\Rules\PersonKana;
use App\Rules\PersonName;
use App\Traits\AuthenticatedBusinessRequests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * 従業員 登録通信
 */
class StaffStoreRequest extends FormRequest
{
    use AuthenticatedBusinessRequests;

    /**
     * バリデーション前処理
     */
    protected function prepareForValidation()
    {
        // メアド入力時 → 該当ユーザーID補完
        $user = User::where('email', $this->input('email'))->first() ?? new User(); // 該当ユーザー 検索(見つからない new)
        // 該当ユーザーID補完
        $this->merge(['user_id' => $user->id]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'last_name' => ['required', 'string', new PersonName],
            'first_name' => ['required', 'string', new PersonName],
            'last_kana' => ['required', 'string', new PersonKana],
            'first_kana' => ['required', 'string', new PersonKana],
            // 登録時 メアドの該当ユーザー ... 事業所にユーザー ユニーク → NG
            'user_id' => [
                'nullable',
                Rule::unique('staff')->where(function($query) {
                    // 同一事業所内に 同一ユーザーいるかの検索
                    $query
                        ->where('business_id', $this->getBusinessId($this))
                        ->whereNotNull('user_id')
                        ->where('user_id', $this->input('user_id'));
                })
            ]
        ];
    }

    /**
     * @return array カスタム エラーメッセージ
     */
    public function messages(): array
    {
        return [
            'user_id.unique' => 'すでに従業員として登録されているメールアドレスです.',
        ];
    }

    /**
     * @return Staff 登録する スタッフ
     */
    public function makeStaff(): Staff
    {
        return new Staff([...$this->input(), 'business_id' => $this->getBusinessId()]);
    }
}
