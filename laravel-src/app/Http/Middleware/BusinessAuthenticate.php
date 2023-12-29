<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BusinessAuthenticate extends Middleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        // (super)ログイン ユーザー認証実行
        $this->authenticate($request, $guards);
        // (独自) 事業所認証 済み
        $this->businesAuthenticate($request, $guards);
        // 次へ
        return $next($request);
    }

    /**
     * 事業所認証 済み判定
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function businesAuthenticate($request, $guards)
    {
        // リクエストユーザーの 操作中事業所 取得
        $business = $request->user()?->operating_business;
        // TODO: guardsを使った 権限チェックやるならここ
        // 見つからない場合 エラー
        if (!$business) throw new AuthenticationException('Business Unauthenticated.', $guards, $this->redirectTo($request));
    }


    /**
     * 未認証時の リダイレクト先
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo(Request $request)
    {
        // API ? 特になし : それ以外(画面操作時) ダッシュボードへ
        return $request->expectsJson() ? null : route('dashboard');
    }
}
