<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\EventController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/member', [HomeController::class, 'member'])->name('member');
Route::get('/board', [HomeController::class, 'board'])->name('board');
// รับค่า {key} เช่น /event/ev1, /event/ev2 ระบบจะรู้เองว่าเป็นงานไหน
Route::get('/event/{key}', [HomeController::class, 'showEvent'])->name('event.show');
Route::get('/setup-data', [HomeController::class, 'setupData']);

// 1. หน้า Login (ไม่ต้องผ่าน Middleware Auth)
Route::get('admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::get('admin/logout', [AuthController::class, 'logout'])->name('admin.logout');


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
    Route::get('events', [EventController::class, 'index'])->name('events.index');
    // หน้าจัดการ event รายตัว (ใช้ {key} รับค่า ev1, ev2)
    Route::get('events/{key}', [EventController::class, 'edit'])->name('events.edit');
    Route::post('events/{key}/details', [EventController::class, 'updateDetails'])->name('events.update_details');
    Route::post('events/{key}/upload', [EventController::class, 'uploadImage'])->name('events.upload');
    Route::delete('events/image/{id}', [EventController::class, 'deleteImage'])->name('events.delete_image');
    
});