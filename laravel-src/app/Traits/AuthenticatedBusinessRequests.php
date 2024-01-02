<?php

namespace App\Traits;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * 事業所 認証後のリクエスト
 */
trait AuthenticatedBusinessRequests
{
    /**
     * @return Business 操作中(認証後)の 事業所 取得
     */
    public function getBusiness(Request $request = null): Business
    {
        // 操作ユーザー情報取得
        $user = $request?->user() ?? Auth::user();
        // 操作中の事業所
        return $user->operating_business->business;
    }
    /**
     * @return int 操作中(認証後)の 事業所ID 取得
     */
    public function getBusinessId(Request $request = null): int
    {
        // 操作中の事業所ID
        return $this->getBusiness($request)->id;
    }
}
