<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

/**
 * 事業所コントローラー
 */
class BusinessController extends Controller
{
    /**
     * 事業所 詳細
     */
    public function show()
    {
        // ログインユーザーの 操作中事業所 取得
        $business = User::find(Auth::id())?->operating_business;
        // 見つからない場合 TOPへ
        if (!$business) return redirect()->route('dashboard');

        // 事業所 詳細へ
        return Inertia::render('Business/Show', compact('business'));
    }
}
