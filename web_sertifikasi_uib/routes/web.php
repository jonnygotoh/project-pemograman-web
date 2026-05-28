<?php

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', [MainController::class, 'home'])->name('home');

Route::get('/mahasiswa', [MainController::class, 'mahasiswa'])
    ->name('listmahasiswa');

Route::get('/calendar/{type}', [MainController::class, 'calendar']);

Route::get('login', [AuthController::class, 'login'])
    ->name('login.choose');

Route::get('login/mahasiswa', [AuthController::class, 'showLoginForm'])
    ->defaults('type', 'student')
    ->name('login.student');

Route::get('login/dosen', [AuthController::class, 'showLoginForm'])
    ->defaults('type', 'lecturer')
    ->name('login.lecturer');

Route::get('login/umum', [AuthController::class, 'showLoginForm'])
    ->defaults('type', 'public')
    ->name('login.public');

Route::post('login/process', [AuthController::class, 'authenticate'])
    ->name('login.process');

Route::get('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/profile', [AuthController::class, 'profile'])
    ->name('profile');

Route::view('/upload-payment', 'pages.upload-payment')
    ->name('upload.payment');

Route::get('/admin', [AuthController::class, 'showLoginAdmin'])->name('login.admin');
Route::post('/admin', [AuthController::class, 'loginAdmin'])->name('login.admin.process');

Route::get('/logout/admin', [AuthController::class, 'logoutAdmin'])->name('logout.admin');

Route::prefix('admin')->middleware(AdminMiddleware::class)->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // SEMINAR
    Route::post('/seminar/store', [AdminController::class, 'seminarStore']);
    Route::post('/seminar/update/{id}', [AdminController::class, 'seminarUpdate']);
    Route::get('/seminar/delete/{id}', [AdminController::class, 'seminarDelete']);

    // SERTIFIKASI
    Route::post('/sertifikasi/store', [AdminController::class, 'sertifikasiStore']);
    Route::post('/sertifikasi/update/{id}', [AdminController::class, 'sertifikasiUpdate']);
    Route::get('/sertifikasi/delete/{id}', [AdminController::class, 'sertifikasiDelete']);
});