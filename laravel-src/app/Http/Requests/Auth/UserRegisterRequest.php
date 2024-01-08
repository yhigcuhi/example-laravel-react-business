<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

/**
 * 会員 登録通信
 */
class UserRegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
    /**
     * @return User 会員 新規登録値
     */
    public function createOfUser(): User
    {
        // 会員新規登録値
        return new User([
            'name' => $this->validated('name'),
            'email' => $this->validated('email'),
            'password' => Hash::make($this->validated('password')),
        ]);
    }
}
