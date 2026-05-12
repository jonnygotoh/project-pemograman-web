<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/mahasiswa', [MahasiswaController::class, 'mahasiswa'])
    ->name('listmahasiswa');

// Route::get('/dosen', [DosenController::class, 'dosen'])
//     ->name('listdosen');

// Route::get('/admin', [AdminController::class, 'admin'])
//     ->name('listadmin');

// Route::get('/umum', [UmumController::class, 'umum'])
//     ->name('listumum');

// Route::get('/sertifikasi', [MahasiswaController::class, 'sertifikasi'])
//     ->name('listsertifikasi');

// Route::get('/seminar', [MahasiswaController::class, 'seminar'])
//     ->name('listseminar');