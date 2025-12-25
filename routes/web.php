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

use App\Models\Member; // <--- เพิ่ม
use App\Models\Event;
use App\Models\TrafficLog;
use Carbon\Carbon;
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
    Route::get('/', [HomeController::class, 'memberHome'])->name('member.home'); // หน้า Dashboard สมาชิก
    Route::get('/info', [HomeController::class, 'member'])->name('member'); // หน้าข้อมูลสมาชิก
    Route::get('/board', [HomeController::class, 'board'])->name('board'); // หน้าสวัสดิการ
    Route::get('/board/{id}', [HomeController::class, 'showBoard'])->name('board.show');
    Route::get('/easypoint', [HomeController::class, 'easyPoint'])->name('easypoint');
    Route::get('/easypoint/{id}', [HomeController::class, 'showEasyPoint'])->name('easypoint.show');
    Route::get('/check', [HomeController::class, 'checkMember'])->name('check.member');
});


// =========================================================================
// 2. ADMIN GUEST (ยังไม่ได้ Login)
// =========================================================================
Route::post('/track-view', [TrackController::class, 'store'])->name('track.view');
Route::prefix('admin')->middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('login', [AuthController::class, 'login']);
    
    // (Optional) Register - ควรเปิดเฉพาะตอน Dev หรือให้เฉพาะ Super Admin สร้างได้
    // Route::get('register', [AuthController::class, 'showRegister'])->name('admin.register');
    // Route::post('register', [AuthController::class, 'register']);
});


// =========================================================================
// 3. ADMIN AUTHENTICATED (เข้าสู่ระบบแล้ว)
// =========================================================================

Route::prefix('admin')->middleware(['auth'])->group(function () {
    
    // Logout
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

    // --- MAIN DASHBOARD (ทางแยก) ---
Route::get('dashboard', function () {
    
    // 1. เตรียมวันย้อนหลัง 7 วัน
    $labels = [];
    $memberData = [];
    $xcademyData = [];
    
    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::today()->subDays($i);
        $labels[] = $date->locale('th')->dayName; // "จันทร์", "อังคาร"
        
        // 2. นับจากตาราง traffic_logs
        $memberData[] = TrafficLog::where('page_name', 'member')
                        ->whereDate('created_at', $date)
                        ->count();
                        
        $xcademyData[] = TrafficLog::where('page_name', 'xcademy')
                        ->whereDate('created_at', $date)
                        ->count();
    }

    return Inertia::render('Admin/Dashboard', [
        'totalMembers' => App\Models\Member::count(),
        'totalEvents'  => App\Models\Event::count(),
        
        // ส่งข้อมูลกราฟ
        'trafficChart' => [
            'labels' => $labels,
            'memberData' => $memberData,
            'xcademyData' => $xcademyData
        ]
    ]);
})->name('admin.dashboard');

    // ---------------------------------------------------------------------
    // GROUP A: MEMBER SYSTEM (จัดการสมาชิก & หน้าเว็บทั่วไป)
    // ---------------------------------------------------------------------
    Route::prefix('member-system')->group(function() {
        
        // 1. จัดการสมาชิก (Member CRUD + Import/Truncate)
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

        // 2. จัดการสวัสดิการ (Board CRUD)
        Route::resource('board', BoardPostController::class)->names([
            'index' => 'admin.board.index',
            'create' => 'admin.board.create',
            'store' => 'admin.board.store',
            'edit' => 'admin.board.edit',
            'update' => 'admin.board.update',
            'destroy' => 'admin.board.destroy',
        ]);

        // 3. จัดการโปรโมชั่น (Promotion)
        Route::get('promotions', [PromotionController::class, 'index'])->name('admin.promotions.index');
        Route::put('promotions/update-all', [PromotionController::class, 'updateAll'])->name('admin.promotions.update_all');

        // 4. แก้ไขเนื้อหาหน้าเว็บ (Page Content)
        Route::get('pages/{key}/edit', [PageContentController::class, 'edit'])->name('admin.pages.edit');
        Route::put('pages/{key}', [PageContentController::class, 'update'])->name('admin.pages.update');
    });


    // ---------------------------------------------------------------------
    // GROUP B: X-CADEMY SYSTEM (จัดการ Event & Slide)
    // ---------------------------------------------------------------------
    Route::prefix('xcademy-system')->group(function() {

        // 1. จัดการ Events
        Route::get('events', [EventController::class, 'index'])->name('admin.events.index');
        Route::post('events/create', [EventController::class, 'create'])->name('admin.events.create');
        Route::get('events/sync', [EventController::class, 'syncFromImageKit'])->name('admin.events.sync');
        
        // จัดการ Event รายตัว (ระบุ Key เช่น ev1)
        Route::get('events/{key}', [EventController::class, 'edit'])->name('admin.events.edit');
        Route::post('events/{key}/details', [EventController::class, 'updateDetails'])->name('admin.events.update_details');
        Route::post('events/{key}/upload', [EventController::class, 'uploadImage'])->name('admin.events.upload');
        Route::delete('events/{key}/delete', [EventController::class, 'destroyEvent'])->name('admin.events.destroy');
        
        // ลบรูปภาพใน Event
        Route::delete('events/image/{id}', [EventController::class, 'deleteImage'])->name('admin.events.delete_image');
    });
    Route::prefix('banner')->group(function () {
        // เปลี่ยน /banners เป็น / (index)
        Route::get('/', [BannerController::class, 'index'])->name('admin.banners.index');
        
        // ส่วนอื่นๆ เหมือนเดิม
        Route::post('/slider', [BannerController::class, 'storeSlider'])->name('admin.banners.slider.store');
        Route::post('/static', [BannerController::class, 'updateStatic'])->name('admin.banners.static.update');
        Route::delete('/{id}', [BannerController::class, 'destroy'])->name('admin.banners.destroy');
    });

});