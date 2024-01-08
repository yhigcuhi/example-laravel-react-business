<?php

use App\Http\Controllers\Invitation\InvitationController;
use App\Http\Controllers\OperatableBusiness\OperatableBusinessController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// 認証済み かつ 内部アクセス(sanctumでのCSRF制御付き)
Route::middleware('auth:sanctum')->group(function() {
    // 認証済みのユーザー取得
    Route::get('/user', fn (Request $request) => $request->user());
    // 操作可能 事業所一覧取得
    Route::prefix('/operatableBusiness')->group(function() {
        Route::get('/', [OperatableBusinessController::class, 'fetchAll']);
    });
    // 招待されている 事業所一覧取得
    Route::prefix('/invitationBusiness')->group(function() {
        Route::get('/', [InvitationController::class, 'fetchAllOfMe']);
    });
});
