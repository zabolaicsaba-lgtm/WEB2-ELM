<?php

use App\Http\Controllers\Admin\TrailController as AdminTrailController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TrailController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TrailController::class, 'home'])->name('home');
Route::get('/adatbazis', [TrailController::class, 'index'])->name('trails.index');
Route::get('/diagram', [TrailController::class, 'chart'])->name('chart');
Route::get('/kapcsolat', [ContactController::class, 'create'])->name('contact.create');
Route::post('/kapcsolat', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

Route::middleware('guest')->group(function () {
    Route::get('/bejelentkezes', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/bejelentkezes', [AuthController::class, 'login'])->middleware('throttle:6,1')->name('login.store');
    Route::get('/regisztracio', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/regisztracio', [AuthController::class, 'register'])->middleware('throttle:4,1')->name('register.store');
});

Route::post('/kijelentkezes', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/uzenetek', [MessageController::class, 'index'])->middleware('auth')->name('messages.index');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('utak', AdminTrailController::class)->parameters(['utak' => 'ut'])->except(['show']);
});