<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\AuthenticatedBusinessController as Controller;
use App\Http\Requests\Business\BusinessUpdateRequest;
use Illuminate\Http\RedirectResponse;

/**
 * 事業所コントローラー
 */
class BusinessController extends Controller
{

    /**
     * 更新
     * @param BusinessUpdateRequest 事業所更新リクエスト
     */
    public function update(BusinessUpdateRequest $request): RedirectResponse
    {
        // 事業所 更新内容設定
        $business = $this->getBusiness($request);
        $business->fill($request->validated());
        // 更新実行
        $business->save();
        // 完了後の画面へ
        return redirect()->route('business.settings.profile');
    }
}
