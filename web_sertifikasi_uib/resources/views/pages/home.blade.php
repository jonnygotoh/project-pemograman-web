@extends('templates.main')
@section('title', 'Beranda UIB Event')
@php($isLanding = true)

@section('content')

<section id="home" class="section hero-section">
    <div class="hero-text">
        <h1>Selamat Datang</h1>
        <h2>Universitas Internasional Batam</h2>
        <p>
            Universitas dengan standar mutu internasional yang menghasilkan lulusan,
            ilmu pengetahuan, teknologi dan seni yang mampu memenuhi perubahan dinamika global.
        </p>
    </div>

    <div class="hero-image">
        <img src="{{ asset('images/education.png') }}" alt="Education Illustration">
    </div>
</section>

{{-- SERTIFIKASI --}}
<section id="sertifikasi" class="section data-section">

    <div class="section-heading">
        <span>Sertifikasi</span>
        <h2>Daftar Sertifikasi</h2>
        <p>Informasi jadwal, biaya, dan pendaftaran sertifikasi.</p>
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
            'columns' => ['Nama', 'Batch', 'Periode', 'Waktu', 'Biaya'],
            'rows' => $certificationRows
        ])
    </div>
</section>

{{-- SEMINAR --}}
<section id="seminar" class="section data-section">

    <div class="section-heading">
        <span>Seminar</span>
        <h2>Daftar Seminar</h2>
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
            'columns' => ['nama', 'periode', 'tanggal', 'waktu', 'tipe'],
            'rows' => $seminarRows
        ])
    </div>
</section>
@endsection