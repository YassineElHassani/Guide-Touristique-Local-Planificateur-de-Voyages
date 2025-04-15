<?php

use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Models\Auth;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'signup'])->name('register.post');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'signin'])->name('login.post');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

route::middleware([AuthMiddleware::class])->group(function () {
    Route::get('/admin', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/guide', [AuthController::class, 'guideDashboard'])->name('guide.dashboard');
    Route::get('/home', [AuthController::class, 'clientDashboard'])->name('travler.dashboard');
});