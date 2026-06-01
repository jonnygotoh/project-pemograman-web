<?php

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PembayaranController;

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

Route::get('register/umum', [AuthController::class, 'showRegisterForm'])->name('register.public');

Route::post('register/process', [AuthController::class, 'registerPublic'])->name('register.process');

Route::post('login/process', [AuthController::class, 'authenticate'])
    ->name('login.process');

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.forgot');

Route::post('/forgot-password', [AuthController::class, 'checkEmail'])->name('password.check');

Route::get('/reset-password/{email}', [AuthController::class, 'showResetForm'])->name('password.reset.form');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset.process');

Route::get('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/profile', [AuthController::class, 'profile'])
    ->name('profile');

Route::get('/admin', [AuthController::class, 'showLoginAdmin'])->name('login.admin');
Route::post('/admin', [AuthController::class, 'loginAdmin'])->name('login.admin.process');

Route::get('/logout/admin', [AuthController::class, 'logoutAdmin'])->name('logout.admin');

Route::prefix('admin')->middleware(AdminMiddleware::class)->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // SEMINAR
    Route::get('/seminar/create', [AdminController::class, 'seminarCreate'])->name('admin.seminar.create');
    // Penambahan ->name() di bawah ini:
    Route::get('/seminar/edit/{id}', [AdminController::class, 'seminarEdit'])->name('admin.seminar.edit');
    Route::post('/seminar/store', [AdminController::class, 'seminarStore'])->name('admin.seminar.store');
    Route::put('/seminar/update/{id}', [AdminController::class, 'seminarUpdate'])->name('admin.seminar.update');
    Route::delete('/seminar/delete/{id}', [AdminController::class, 'seminarDelete'])->name('admin.seminar.delete');
    Route::post('/seminar/upload-sertifikat/{id}', [AdminController::class, 'updateSertifikatSeminar'])
    ->name('admin.seminar.uploadSertifikat');

    // SERTIFIKASI
    Route::get('/sertifikasi/create', [AdminController::class, 'sertifikasiCreate'])->name('admin.sertifikasi.create');
    // Penambahan ->name() di bawah ini:
    Route::get('/sertifikasi/edit/{id}', [AdminController::class, 'sertifikasiEdit'])->name('admin.sertifikasi.edit');
    Route::post('/sertifikasi/store', [AdminController::class, 'sertifikasiStore'])->name('admin.sertifikasi.store');
    Route::put('/sertifikasi/update/{id}', [AdminController::class, 'sertifikasiUpdate'])->name('admin.sertifikasi.update');
    Route::delete('/sertifikasi/delete/{id}', [AdminController::class, 'sertifikasiDelete'])->name('admin.sertifikasi.delete');
    
    Route::post('/verifikasi-pembayaran/{id}', [AdminController::class, 'verifikasiPembayaran'])->name('admin.verifikasi.pembayaran');
});

//menampilkan detail sertifikasi-seminar
Route::get('/detailseminar/{id}', [MainController::class, 'showSeminar'])->name('seminar.show');
Route::get('/detailsertifikasi/{id}', [MainController::class, 'showSertifikasi'])->name('sertifikasi.show');
// pembayaran
Route::post('/pembayaran-sertifikasi', [PembayaranController::class, 'store'])->name('pendaftaran.store');
Route::delete('/pembayaran/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');
Route::get('/bukti-bayar/{filename}', [PembayaranController::class, 'viewBuktiBayar'])->name('bukti.view');

Route::get('/upload-payment/{sertifikasi_id}', [MainController::class, 'showUploadPage'])->name('upload.payment');

Route::post('/profile/verifikasi-token-seminar', [App\Http\Controllers\MainController::class, 'verifikasiTokenSeminar'])
    ->name('verifikasi.token.seminar');

