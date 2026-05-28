@extends('templates.main')
@section('title', 'Admin Dashboard - UIB Event')
@php($isLanding = true)

@section('content')

{{-- Info Bar Admin --}}
<div style="background: #2d3748; color: #fff; padding: 15px; text-align: center; margin-top: 80px;">
    <strong>Mode Admin:</strong> Anda sedang melihat halaman manajemen. <a href="{{ route('logout.admin') }}" style="color: #ff9999; margin-left: 20px;">Logout Admin</a>
</div>

<section id="home" class="section hero-section loaded-active no-select">
    <div class="hero-text js-reveal">
        <h1 class="delay-1">Selamat Datang Admin</h1>
        <h2 class="delay-2">{{ session('admin_name') }}</h2>
        <p class="delay-3">Gunakan menu di bawah untuk mengelola data event UIB.</p>
    </div>
</section>

<section id="sertifikasi" class="section data-section">
    <div class="section-heading js-reveal">
        <span class="delay-1">Sertifikasi</span>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="delay-2">Daftar Sertifikasi</h2>
            <button onclick="openModalTambah('sertifikasi')" class="btn-primary" style="padding: 10px 20px; background: #2563eb; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
                + Tambah Sertifikasi
            </button>
        </div>
        <div class="heading-line"></div>
    </div>

    <div id="sertifikasi-calendar" class="view-panel">
        @include('pages.partials.calendar', ['type' => 'sertifikasi', 'month' => $month, 'year' => $year, 'calendarDays' => $certificationCalendar])
    </div>
</section>

<section id="seminar" class="section data-section">
    <div class="section-heading js-reveal">
        <span class="delay-1">Seminar</span>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="delay-2">Daftar Seminar</h2>
            <button onclick="openModalTambah('seminar')" class="btn-primary" style="padding: 10px 20px; background: #2563eb; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
                + Tambah Seminar
            </button>
        </div>
        <div class="heading-line"></div>
    </div>

    <div id="seminar-calendar" class="view-panel">
        @include('pages.partials.calendar', ['type' => 'seminar', 'month' => $month, 'year' => $year, 'calendarDays' => $seminarCalendar])
    </div>
</section>
@endsection