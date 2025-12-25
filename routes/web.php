<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Controllers - Public
use App\Http\Controllers\HomeController;

// Controllers - Admin
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\BoardPostController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\BannerController;

use App\Models\Member;
use App\Models\Event;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. PUBLIC ROUTES (หน้าบ้าน)
// =========================================================================

Route::get('/', [HomeController::class, 'index'])->name('landing');
Route::get('/xcademy', [HomeController::class, 'xcademy'])->name('xcademy');

// กลุ่มหน้าสมาชิก (Member Zone)
Route::prefix('member')->group(function () {
    Route::get('/', [HomeController::class, 'memberHome'])->name('member.home');
    Route::get('/info', [HomeController::class, 'member'])->name('member');
    Route::get('/board', [HomeController::class, 'board'])->name('board');
    Route::get('/board/{id}', [HomeController::class, 'showBoard'])->name('board.show');
    Route::get('/easypoint', [HomeController::class, 'easyPoint'])->name('easypoint');
    Route::get('/easypoint/{id}', [HomeController::class, 'showEasyPoint'])->name('easypoint.show');
    Route::get('/check', [HomeController::class, 'checkMember'])->name('check.member');
});


// =========================================================================
// 2. ADMIN GUEST (ยังไม่ได้ Login)
// =========================================================================
Route::prefix('admin')->middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('login', [AuthController::class, 'login']);
});


// =========================================================================
// 3. ADMIN AUTHENTICATED (เข้าสู่ระบบแล้ว)
// =========================================================================

Route::prefix('admin')->middleware(['auth'])->group(function () {
    
    // Logout
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

    // --- MAIN DASHBOARD ---
    Route::get('dashboard', function () {
        return Inertia::render('Admin/Dashboard', [
            'totalMembers' => Member::count(),
            'totalEvents'  => Event::count(),
        ]);
    })->name('admin.dashboard');

    // ---------------------------------------------------------------------
    // GROUP A: MEMBER SYSTEM
    // ---------------------------------------------------------------------
    Route::prefix('member-system')->group(function() {
        
        // 1. จัดการสมาชิก
        Route::delete('members/truncate', [MemberController::class, 'truncate'])->name('admin.members.truncate');
        Route::post('members/import', [MemberController::class, 'import'])->name('admin.members.import');
        Route::resource('members', MemberController::class)->names([
            'index' => 'admin.members.index',
            'create' => 'admin.members.create',
            'store' => 'admin.members.store',
            'edit' => 'admin.members.edit',
            'update' => 'admin.members.update',
            'destroy' => 'admin.members.destroy',
        ]);

        // 2. จัดการสวัสดิการ
        Route::resource('board', BoardPostController::class)->names([
            'index' => 'admin.board.index',
            'create' => 'admin.board.create',
            'store' => 'admin.board.store',
            'edit' => 'admin.board.edit',
            'update' => 'admin.board.update',
            'destroy' => 'admin.board.destroy',
        ]);

        // 3. จัดการโปรโมชั่น
        Route::get('promotions', [PromotionController::class, 'index'])->name('admin.promotions.index');
        Route::put('promotions/update-all', [PromotionController::class, 'updateAll'])->name('admin.promotions.update_all');

        // 4. แก้ไขเนื้อหาหน้าเว็บ
        Route::get('pages/{key}/edit', [PageContentController::class, 'edit'])->name('admin.pages.edit');
        Route::put('pages/{key}', [PageContentController::class, 'update'])->name('admin.pages.update');
    });


    // ---------------------------------------------------------------------
    // GROUP B: X-CADEMY SYSTEM
    // ---------------------------------------------------------------------
    Route::prefix('xcademy-system')->group(function() {

        // จัดการ Events
        Route::get('events', [EventController::class, 'index'])->name('admin.events.index');
        Route::post('events/create', [EventController::class, 'create'])->name('admin.events.create');
        Route::get('events/sync', [EventController::class, 'syncFromImageKit'])->name('admin.events.sync');
        
        // จัดการ Event รายตัว
        Route::get('events/{key}', [EventController::class, 'edit'])->name('admin.events.edit');
        Route::post('events/{key}/details', [EventController::class, 'updateDetails'])->name('admin.events.update_details');
        Route::post('events/{key}/upload', [EventController::class, 'uploadImage'])->name('admin.events.upload');
        Route::delete('events/{key}/delete', [EventController::class, 'destroyEvent'])->name('admin.events.destroy');
        
        Route::delete('events/image/{id}', [EventController::class, 'deleteImage'])->name('admin.events.delete_image');
    });

    // ---------------------------------------------------------------------
    // GROUP C: BANNER SYSTEM
    // ---------------------------------------------------------------------
    Route::prefix('banner')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('admin.banners.index');
        Route::post('/slider', [BannerController::class, 'storeSlider'])->name('admin.banners.slider.store');
        Route::post('/static', [BannerController::class, 'updateStatic'])->name('admin.banners.static.update');
        Route::delete('/{id}', [BannerController::class, 'destroy'])->name('admin.banners.destroy');
    });

});