<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\QueryBuilders\UserInvitationQueryBuilder;
use App\Models\User;
use App\Models\UserOperatableBusiness;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

/**
 * ダッシュボード コントローラー
 */
class DashboardController extends Controller
{
    /**
     * ダッシュボード TOP画面表示
     */
    public function index()
    {
        // ログインユーザー取得
        $user_id = Auth::id();
        // ログインユーザー 操作可能 事業所一覧
        $operatable_businesses = UserOperatableBusiness::query()->with('business')->where('user_id', $user_id)->get();
        // ログインユーザー (未承認の)招待 事業所一覧
        $user_invitations = UserInvitationQueryBuilder::buildUnVerifeidAllOfMe()->get();

        // (未承認の)招待 事業所あり → ダッシュボード画面表示
        if (count($user_invitations) > 0) return Inertia::render('Dashboard');
        // 操作可能 事業所 1件: 事業所TOPへ リダイレクト
        if (count($operatable_businesses) === 1) {
            User::find(Auth::id())->operating($operatable_businesses->get(0)->business_id);
            return redirect()->route('business.show');
        }
        // それ以外 複数件: ダッシュボード画面表示
        return Inertia::render('Dashboard');
    }
}
