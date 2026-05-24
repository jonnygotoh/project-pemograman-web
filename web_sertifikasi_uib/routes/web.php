<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

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

