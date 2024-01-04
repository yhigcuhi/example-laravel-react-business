<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\AuthenticatedBusinessController as Controller;
use App\Http\Requests\Staff\StaffStoreRequest;
use App\Http\Requests\Staff\StaffUpdateRequest;
use App\Models\Staff;
use App\Http\UseCases\Staff\SearchAction;
use App\Http\UseCases\Staff\StoreAction;
use App\Http\UseCases\Staff\UpdateAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
/**
 * 従業員コントローラー
 */
class StaffController extends Controller
{

    /**
     * @param Request $request 検索条件
     * @param SearchAction $action 検索アクション
     * @return \Inertia\Response 一覧画面表示
     */
    public function index(Request $request, SearchAction $action): \Inertia\Response
    {
        // 事業所 所属スタッフ 一覧 検索(ページ数20)
        $staff = $action($this->getBusinessId(), $request->all(), 20);
        // 一覧画面表示
        return Inertia::render('Business/Settings/Staff', compact('staff'));
    }

    /**
     * @return \Inertia\Response 新規登録画面
     */
    public function create(): \Inertia\Response
    {
        // 登録 スタッフ 初期値
        $staff = new Staff([
            'business_id' => $this->getBusinessId(), // 事業所ID = 現在操作中
        ]);
        // 登録画面表示
        return Inertia::render('Business/Settings/CreateStaff', compact('staff'));
    }

    /**
     * 登録
     * @param StaffStoreRequest $request 登録通信
     * @param StoreAction $action 登録アクション
     * @return RedirectResponse 登録後 画面
     */
    public function store(StaffStoreRequest $request, StoreAction $action): RedirectResponse
    {
        // 従業員 登録実行
        $action($request->makeStaff(), $request->input('email'));
        // 一覧画面へ
        return redirect()->route('business.settings.staff.index');
    }

    /**
     * @param int $id 編集アイテム
     * @return \Inertia\Response 編集画面
     */
    public function edit(int $id): \Inertia\Response
    {
        // 編集 アイテム 取得 (他人の事業所が編集できないように 事業所指定も必須で)
        $staff = Staff::where('id', $id)->where('business_id', $this->getBusinessId())->first();
        // 編集画面表示
        return Inertia::render('Business/Settings/EditStaff', compact('staff'));
    }

    /**
     * 更新
     * @param StaffUpdateRequest $request 更新通信
     * @param UpdateAction $action 更新アクション
     * @return RedirectResponse 更新後 画面
     */
    public function update(StaffUpdateRequest $request, UpdateAction $action): RedirectResponse
    {
        // 前提条件
        if (!$request->makeStaff()) throw new NotFoundHttpException('staff is not found belong your business.');

        // 従業員 更新実行
        $action($request->makeStaff(), $request->input('email'));
        // 一覧画面へ
        return redirect()->route('business.settings.staff.index');
    }
}
