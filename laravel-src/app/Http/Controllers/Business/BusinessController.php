<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\AuthenticatedBusinessController as Controller;
use App\Http\Requests\Business\BusinessUpdateRequest;
use App\UseCases\Business\PatchAction;
use Illuminate\Http\RedirectResponse;

/**
 * 事業所コントローラー
 */
class BusinessController extends Controller
{

    /**
     * 更新
     * @param BusinessUpdateRequest 事業所更新リクエスト
     * @param PatchAction $action 更新アクション
     */
    public function update(BusinessUpdateRequest $request, PatchAction $action): RedirectResponse
    {
        // 更新実行
        $action($request->makeBusiness());
        // 完了後の画面へ
        return redirect()->route('business.settings.profile');
    }
}
