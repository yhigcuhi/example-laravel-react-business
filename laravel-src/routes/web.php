<?php

use App\Http\Controllers\Business\BusinessController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Invitation\InvitationController;
use App\Http\Controllers\OperatableBusiness\OperatableBusinessController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Staff\StaffController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// breeze デフォルト インデックスページ
// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
// アプリケーションとしてのインデックス(ダッシュボードへ)
Route::get('/', fn() => redirect('/dashboard'));

// 認証後 →　ダッシュボードへ
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
// ログイン後
Route::middleware('auth')->group(function () {
    // プロフィール系
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // 操作可能 事業所
    Route::name('operatableBusiness.')->prefix('/operatableBusiness')->group(function() {
        Route::patch('/operating/{id}', [OperatableBusinessController::class, 'operating'])->name('operating');
    });
    // 招待
    Route::name('invitation.')->prefix('/invitation')->group(function() {
        // 招待 承認
        Route::patch('/verifeid/{id}', [InvitationController::class, 'verifeid'])->name('verifeid');
    });
});
// 事業所 認証後
Route::middleware(['auth', 'auth.business'])->group(function() {
    // 事業所 設定
    Route::get('/business', fn() => redirect()->route('business.show'))->name('business');
    Route::name('business.')->prefix('/business')->group(function() {
        // 事業所 詳細
        Route::get('/show', fn() => Inertia::render('Business/Show'))->name('show');
        // 事業所 設定 TOP
        Route::get('/settings', fn() => redirect()->route('business.settings.profile'))->name('settings');
    });
    // 事業所 設定
    Route::name('business.settings.')->prefix('/business/settings')->group(function() {
        // 基本情報
        Route::get('/profile', fn() => Inertia::render('Business/Settings/Profile'))->name('profile');
        Route::patch('/profile', [BusinessController::class, 'update'])->name('profile.update');
        // 従業員 管理
        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index'); // 一覧画面
        Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create'); // 登録画面
        Route::post('/staff/create', [StaffController::class, 'store'])->name('staff.store'); // 登録通信
        Route::get('/staff/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit'); // 編集画面
        Route::patch('/staff/edit/{id}', [StaffController::class, 'update'])->name('staff.update'); // 編集通信
    });
});
// (未ログイン | アカウントなし | ログイン済み OK) 事業所 招待
Route::name('invitation.')->prefix('/invitation')->group(function() {
    // 招待通知 受信 → リンク開いた後(受け取り: 確認)
    Route::get('/verify/mail/{invitation_token}', [InvitationController::class, 'verify'])->name('verify');
    // 招待有効期限切れ とか用のエラー画面
    Route::get('/verify/error', fn () => Inertia::render('Invitation/Error'))->name('verify.error');
    // 会員登録 by 招待
    Route::middleware('guest')->group(function () {
        Route::get('/register/{invitation_token}', [InvitationController::class, 'userRegister'])->name('user.register');
        Route::post('/register/{invitation_token}', [InvitationController::class, 'userRegisterStore'])->name('user.register.store');
    });
});


// Breezeの会員登録など
require __DIR__.'/auth.php';
