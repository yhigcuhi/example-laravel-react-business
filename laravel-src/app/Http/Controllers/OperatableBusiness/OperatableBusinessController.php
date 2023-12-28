<?php

namespace App\Http\Controllers\OperatableBusiness;

use App\Http\Controllers\Controller;
use App\Http\Requests\OperatableBusiness\OperatableBusinessOperatingRequest;
use App\Models\User;
use App\Models\UserOperatableBusiness;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

/**
 * 操作可能 事業所コントローラー
 */
class OperatableBusinessController extends Controller
{
    /**
     * 一覧取得
     */
    public function fetchAll(): JsonResponse
    {
        // ログインユーザー取得
        $user_id = Auth::id();
        // ログインユーザー 操作可能 事業所一覧
        $operatableBusinesses = UserOperatableBusiness::query()->with('business')->where('user_id', $user_id)->get();
        // JSON返却
        return response()->json(['data' => $operatableBusinesses]);
    }

    /**
     * 操作中へ
     * @param int 操作中にする ユーザー操作可能 事業所のID
     */
    public function operating(int $id)
    {
        // 対象の事業所取得
        $business_id = UserOperatableBusiness::find($id)?->business_id;
        // ユーザー 操作中の事業所へ更新
        User::find(Auth::id())?->operating($business_id);
        // 事業所 詳細へ リダイレクト
        return redirect()->route('business.show');
    }
}
