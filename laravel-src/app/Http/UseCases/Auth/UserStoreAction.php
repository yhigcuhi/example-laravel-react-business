<?php

namespace App\Http\UseCases\Auth;
;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

/**
 * ユースケース : 会員 登録
 */
class UserStoreAction
{
    /**
     * アクション 実行
     * @param User $user 登録値
     */
    public function __invoke(User $user): User
    {
        // 前提条件
        if ($user->id) return $user; //　登録済み → 何もしない
        // 会員登録
        $user->save();
        // 会員登録イベント発火
        event(new Registered($user));

        // 登録結果
        return $user;
    }
}
