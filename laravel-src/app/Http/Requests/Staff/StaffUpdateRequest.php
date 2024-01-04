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
 * 従業員 更新通信
 */
class StaffUpdateRequest extends FormRequest
{
    use AuthenticatedBusinessRequests;

    /**
     * バリデーション前処理
     */
    protected function prepareForValidation()
    {
        // 更新するスタッフ
        $staff = $this->findStaff();
        // 存在しない → 何もしない
        if (!$staff) return;

        // バリデーションルールを使うため id merge
        $this->merge(['id' => $this->getId()]);
        // ユーザーID 未紐付けの時 → メアド入力時から 該当ユーザーID補完
        if (is_null($staff->user_id)) {
            // メアド入力時 → 該当ユーザーID補完
            $user = User::where('email', $this->input('email'))->first() ?? new User(); // 該当ユーザー 検索(見つからない new)
            // 該当ユーザーID補完
            $this->merge(['user_id' => $user->id]);
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'exists:staff'],
            'last_name' => ['required', 'string', new PersonName],
            'first_name' => ['required', 'string', new PersonName],
            'last_kana' => ['required', 'string', new PersonKana],
            'first_kana' => ['required', 'string', new PersonKana],
            // 更新時 メアドの該当ユーザー ... 事業所にユーザー ユニーク → NG
            'user_id' => [
                'nullable',
                Rule::unique('staff')->ignore($this->getId())->where(function($query) {
                    // 同一事業所内に 同一ユーザーいるかの検索
                    $query
                        ->where('business_id', $this->getBusinessId())
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
     * @return Staff|null 更新する スタッフ
     */
    public function makeStaff(): ?Staff
    {
        // 更新するスタッフ 検索
        $staff = $this->findStaff();
        if (!$staff) return null;
        // 更新値 反映
        $staff->fill([...$this->input(), 'business_id' => $this->getBusinessId()]);
        // 返却
        return $staff;
    }

    /**
     * @return Staff|null 更新するスタッフ
     */
    public function findStaff(): ?Staff
    {
        return Staff::where('id', $this->getId())->where('business_id', $this->getBusinessId())->first();
    }

    /**
     * @return int 編集アイテム ID
     */
    public function getId(): int
    {
        return (int) $this->route('id');
    }
}
