<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\MemberCheckController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/member', [HomeController::class, 'member'])->name('member');
Route::get('/board', [HomeController::class, 'board'])->name('board');
// รับค่า {key} เช่น /event/ev1, /event/ev2 ระบบจะรู้เองว่าเป็นงานไหน
Route::get('/event/{key}', [HomeController::class, 'showEvent'])->name('event.show');
Route::get('/setup-data', [HomeController::class, 'setupData']);
// หน้าค้นหาสมาชิก (ทุกคนเข้าได้)
Route::get('/check-member', [MemberCheckController::class, 'index'])->name('check.member');

// 1. หน้า Login (ไม่ต้องผ่าน Middleware Auth)
Route::get('admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::get('admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// ... (Route Login เดิม)
Route::get('admin/registerCMUXCADEMY', [AuthController::class, 'showRegister'])->name('admin.register');
Route::post('admin/register', [AuthController::class, 'register'])->name('admin.register.submit');

// 2. หน้า Admin (ต้อง Login ก่อนถึงเข้าได้)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manage Slides & Banners
    Route::get('slides', [SlideController::class, 'index'])->name('slides.index');
    Route::post('slides', [SlideController::class, 'store'])->name('slides.store');
    Route::delete('slides/{id}', [SlideController::class, 'destroy'])->name('slides.destroy');
    Route::get('slides/sync', [SlideController::class, 'syncFromImageKit'])->name('slides.sync');
    // Manage Events (Dynamic Key: ev1, ev2, ...)
    // หน้า list รวม
    Route::get('events/sync', [EventController::class, 'syncFromImageKit'])->name('events.sync');
    Route::get('events', [EventController::class, 'index'])->name('events.index');
    // หน้าจัดการ event รายตัว (ใช้ {key} รับค่า ev1, ev2)
    Route::get('events/{key}', [EventController::class, 'edit'])->name('events.edit');
    Route::post('events/{key}/details', [EventController::class, 'updateDetails'])->name('events.update_details');
    Route::post('events/{key}/upload', [EventController::class, 'uploadImage'])->name('events.upload');
    Route::delete('events/image/{id}', [EventController::class, 'deleteImage'])->name('events.delete_image');
    // ฟังก์ชัน Upload Excel (ควรซ่อนไว้ หรือใส่ Middleware auth เพื่อให้ Admin ใช้เท่านั้น)
    Route::post('/import-members', [MemberCheckController::class, 'import'])->name('import.members');
    Route::delete('members/truncate', [App\Http\Controllers\Admin\MemberController::class, 'truncate'])->name('members.truncate');
    Route::post('members/import', [App\Http\Controllers\Admin\MemberController::class, 'import'])->name('members.import');
    Route::resource('members', App\Http\Controllers\Admin\MemberController::class);

    Route::get('promotions', [App\Http\Controllers\Admin\PromotionController::class, 'index'])->name('promotions.index');
    Route::put('promotions/update-all', [App\Http\Controllers\Admin\PromotionController::class, 'updateAll'])->name('promotions.update_all');
    Route::put('promotions/{id}', [App\Http\Controllers\Admin\PromotionController::class, 'update'])->name('promotions.update');
    // จัดการเนื้อหาหน้าเว็บ (Member, Board)
    Route::get('pages/{key}/edit', [App\Http\Controllers\Admin\PageContentController::class, 'edit'])->name('pages.edit');
    Route::put('pages/{key}', [App\Http\Controllers\Admin\PageContentController::class, 'update'])->name('pages.update');

});
    
