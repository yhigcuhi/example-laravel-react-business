<?php

namespace App\Http\Requests\Business;

use App\Models\Business;
use App\Traits\AuthenticatedBusinessRequests;
use Illuminate\Foundation\Http\FormRequest;

class BusinessUpdateRequest extends FormRequest
{
    use AuthenticatedBusinessRequests;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }

    /**
     * @return Business 更新する 事業所
     */
    public function makeBusiness(): Business
    {
        // 事業所 更新内容設定
        $business = $this->getBusiness($this);
        $business->fill($this->validated());
        // 結果返却
        return $business;
    }
}
