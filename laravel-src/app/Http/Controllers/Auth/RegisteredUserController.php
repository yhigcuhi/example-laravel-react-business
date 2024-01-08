<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Http\UseCases\Auth\UserStoreAction;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param UserRegisterRequest $request 会員登録通信
     * @param UserStoreAction $action 会員登録アクション
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRegisterRequest $request, UserStoreAction $action): RedirectResponse
    {
        // 会員登録 実行
        $user = $action($request->createOfUser());
        // ログイン セッション登録
        Auth::login($user);
        // 画面遷移
        return redirect(RouteServiceProvider::HOME);
    }
}
