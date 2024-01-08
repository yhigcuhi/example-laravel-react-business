<?php

namespace App\Http\Controllers\Invitation;

use App\Http\Controllers\AuthenticatedBusinessController as Controller;
use App\Http\Requests\Invitation\InvitationUserRegisterRequest;
use App\Http\Requests\Invitation\InvitationVerifyRequest;
use App\Http\UseCases\Auth\UserStoreAction;
use App\Http\UseCases\Invitation\InvitationVerifiedAction;
use App\Models\Invitation;
use App\Models\QueryBuilders\UserInvitationQueryBuilder;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * 招待 コントローラー
 */
class InvitationController extends Controller
{
    /**
     * 招待通知 確認
     * @param InvitationVerifyRequest $request 招待通知 確認 通信
     * @param string $invitation_token 招待トークン(招待コード)
     */
    public function verify(InvitationVerifyRequest $request, string $invitation_token): RedirectResponse
    {
        // 該当招待 取得
        $invitation = $request->getInvitation();

        // 会員 未登録 → 会員登録 by 招待
        if (!$invitation->user) return redirect()->route('invitation.user.register', compact('invitation_token'));
        // 会員 登録済み:メアド未認証 → メアド承認日時 更新 TODO:user.verifyed_at? を更新
        // 会員 登録済み → 招待承認 (Dashboard) 表示
        return redirect()->route('dashboard');
    }

    /**
     * @param string $invitation_token 招待トークン(招待コード)
     * @return \Inertia\Response 会員登録 by 招待 画面表示
     */
    public function userRegister(string $invitation_token): \Inertia\Response
    {
        // 画面表示
        return Inertia::render('Invitation/InvitationUserRegister', compact('invitation_token'));
    }

    /**
     * @param InvitationUserRegisterRequest 会員登録 by 招待 通信
     * @param UserStoreAction $action 会員登録 アクション
     */
    public function userRegisterStore(InvitationUserRegisterRequest $request, UserStoreAction $action): RedirectResponse
    {
        // トランザクション開始
        DB::beginTransaction();
        try {
            // 会員登録 by 招待 実行
            $user = $action($request->createOfUser());
            // ログイン セッション登録
            Auth::login($user);
            // コミット
            DB::commit();
            // 画面遷移
            return redirect(RouteServiceProvider::HOME);
        // Http例外 → 該当コード
        } catch (HttpException $e) {
            // ロールバック
            DB::rollBack();
            Log::error($e->getTraceAsString());
            // エラーコードで返却
            throw $e;
        // その他例外 → 500
        } catch (Exception $e) {
            // ロールバック
            DB::rollBack();
            Log::error($e->getTraceAsString());
            // エラーコードで返却
            throw new HttpException(500, 'サーバーエラー', $e);
        }
    }

    /**
     * @return JsonResponse ログインユーザーへの 事業所 招待一覧
     */
    public function fetchAllOfMe(): JsonResponse
    {
        // ログインユーザー (未承認の)招待 事業所一覧
        $user_invitations = UserInvitationQueryBuilder::buildUnVerifeidAllOfMe()->with('business')->get();
        // JSON返却
        return response()->json(['data' => $user_invitations]);
    }

    /**
     * 招待承認
     * @param int $id 招待承認された 招待ID
     * @param InvitationVerifiedAction $action 承認 アクション
     */
    public function verifeid(int $id, InvitationVerifiedAction $action): RedirectResponse
    {
        // 該当の招待 承認
        $action(Invitation::find($id));
        // リダイレクト ダッシュボード
        return redirect()->route('dashboard');
    }
}
