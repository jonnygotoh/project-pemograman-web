@extends('templates.main')
@section('title', 'Beranda UIB Event')
@php($isLanding = true)

@section('content')

<section id="home" class="section hero-section loaded-active no-select">
    <div class="hero-text js-reveal">
        <h1 class="delay-1">Selamat Datang</h1>
        <h2 class="delay-2">Universitas Internasional Batam</h2>
        <p class="delay-3">
            Universitas dengan standar mutu internasional yang menghasilkan lulusan,
            ilmu pengetahuan, teknologi dan seni yang mampu memenuhi perubahan dinamika global.
        </p>
    </div>

    <div class="hero-image js-reveal-img">
        <img src="{{ asset('images/education.png') }}" alt="Education Illustration" class="delay-4">
    </div>
</section>

<section id="sertifikasi" class="section data-section">
    <div class="section-heading js-reveal" id="center">
        <span class="delay-1">Sertifikasi</span>
        <h2 class="delay-2">Daftar Sertifikasi</h2>
        <div class="heading-line"></div>
    </div>

    <div class="view-toggle">
        <button class="active" onclick="switchView('sertifikasi','calendar')">Kalender</button>
        <button onclick="switchView('sertifikasi','table')">Tabel</button>
    </div>

    <div id="sertifikasi-calendar" class="view-panel">
        @include('pages.partials.calendar', [
            'type' => 'sertifikasi',
            'month' => $month,
            'year' => $year,
            'calendarDays' => $certificationCalendar
        ])
    </div>

    <div id="sertifikasi-table" class="view-panel hidden">
        @include('pages.partials.table', [
             'pageTitle' => 'Sertifikasi',
            'type' => 'sertifikasi',
            'columns' => ['No', 'Nama Sertifikasi', 'Periode Pendaftaran', 'Tanggal Pelatihan', 'Tanggal Ujian', 'Biaya Pendaftaran', 'Jumlah Pendaftar'],
            'rows' => $certificationRows
        ])
    </div>
</section>

<section id="seminar" class="section data-section">
    <div class="section-heading js-reveal" id="center">
        <span class="delay-1">Seminar</span>
        <h2 class="delay-2">Daftar Seminar</h2>
        <div class="heading-line"> </div>
        <div class="card-grid"></div>
    </div>

    <div class="view-toggle">
        <button class="active" onclick="switchView('seminar','calendar')">Kalender</button>
        <button onclick="switchView('seminar','table')">Tabel</button>
    </div>

    <div id="seminar-calendar" class="view-panel">
        @include('pages.partials.calendar', [
            'type' => 'seminar',
            'month' => $month,
            'year' => $year,
            'calendarDays' => $seminarCalendar
        ])
    </div>

    <div id="seminar-table" class="view-panel hidden">
        @include('pages.partials.table', [
            'pageTitle' => 'Seminar',
            'type' => 'seminar',
            'columns' => ['No', 'Nama', 'Periode', 'Tanggal', 'Waktu', 'Biaya', 'Pendaftar'],
            'rows' => $seminarRows
        ])
    </div>
</section>
@endsection