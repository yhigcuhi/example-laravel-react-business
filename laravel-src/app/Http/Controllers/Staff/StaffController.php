<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\AuthenticatedBusinessController as Controller;
use App\Http\Requests\Staff\StaffStoreRequest;
use App\Models\Staff;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
/**
 * 従業員コントローラー
 */
class StaffController extends Controller
{

    /**
     * @return \Inertia\Response 一覧画面表示
     */
    public function index(): \Inertia\Response
    {
        // 事業所 所属スタッフ 一覧
        $staff = Staff::where('business_id', $this->getBusinessId())->orderBy('id')->paginate(20);
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
     * @return RedirectResponse 登録後 画面
     */
    public function store(StaffStoreRequest $request): RedirectResponse
    {
        // 登録値 従業員 補完
        $staff = $request->makeStaff();
        // 従業員 新規追加
        $staff->save();

        // メアド指定あり → 事業所 招待メール追加 TODO:今後、仕様.mdの招待参照
        // if ($request->input('email'))

        // 一覧画面へ
        return redirect()->route('business.settings.staff.index');
    }
}
