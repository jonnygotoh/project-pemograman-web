<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

Route::get('/', [MainController::class, 'home'])->name('home');

Route::get('/mahasiswa', [MainController::class, 'mahasiswa'])
    ->name('listmahasiswa');

Route::get('login', [AuthController::class, 'login'])
    ->name('login.choose');

Route::get('login/mahasiswa', fn () => view('auth.login', [
    'title' => 'Masuk Mahasiswa',
    'identityPlaceholder' => 'NPM',
    'type' => 'student',
    'note' => 'Login mahasiswa'
]))->name('login.student');

Route::get('login/dosen', fn () => view('auth.login', [
    'title' => 'Masuk Dosen',
    'identityPlaceholder' => 'NIDN / Email',
    'type' => 'lecturer',
    'note' => 'Login dosen'
]))->name('login.lecturer');

Route::get('login/umum', fn () => view('auth.login', [
    'title' => 'Masuk Umum',
    'identityPlaceholder' => 'Email',
    'type' => 'public',
]))->name('login.public');

Route::post('login/process', fn () => back())->name('login.process');

Route::get('/logout', fn () => redirect('/'))->name('logout');

Route::view('/upload-payment', 'pages.upload-payment')
    ->name('upload.payment');