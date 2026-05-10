<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/Mahasiswa', [MahasiswaController::class, 'mahasiswa'])
    ->name('mahasiswa');

Route::get('/Dosen', [MahasiswaController::class, 'dosen'])
    ->name('dosen');

Route::get('/Admin', [MahasiswaController::class, 'admin'])
    ->name('admin');

Route::get('/Sertifikasi', [MahasiswaController::class, 'sertifikasi'])
    ->name('sertifikasi');

Route::get('/Seminar', [MahasiswaController::class, 'seminar'])
    ->name('seminar');