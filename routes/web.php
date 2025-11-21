<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/member', [HomeController::class, 'member'])->name('member');
Route::get('/board', [HomeController::class, 'board'])->name('board');
// รับค่า {key} เช่น /event/ev1, /event/ev2 ระบบจะรู้เองว่าเป็นงานไหน
Route::get('/event/{key}', [HomeController::class, 'showEvent'])->name('event.show');
Route::get('/setup-data', [HomeController::class, 'setupData']);