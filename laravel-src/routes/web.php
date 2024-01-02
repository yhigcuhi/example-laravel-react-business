<?php

use App\Http\Controllers\Business\BusinessController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\OperatableBusiness\OperatableBusinessController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Staff\StaffController;
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
    });
});

// Breezeの会員登録など
require __DIR__.'/auth.php';
