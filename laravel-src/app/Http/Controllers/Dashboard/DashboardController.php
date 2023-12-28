<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\UserOperatableBusiness;
use Illuminate\Http\Request;
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
        $businesses = UserOperatableBusiness::query()->with('business')->where('user_id', $user_id)->get();

        // 操作可能 事業所 1件: 事業所TOPへ リダイレクト TODO:事業所TOP作ったら
        if (count($businesses) === 1) return redirect()->route('business.show');
        // 複数件: ダッシュボード画面表示
        return Inertia::render('Dashboard');
    }
}