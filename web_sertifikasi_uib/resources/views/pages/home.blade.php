@extends('layouts.app')
@section('title', 'Beranda UIB Event')
@php($isLanding = true)

@section('content')
<section id="home" class="section hero-section">
    <div class="hero-text">
        <h1>Selamat Datang</h1>
        <h2>Universitas Internasional Batam</h2>
        <p>Universitas dengan standar mutu internasional yang menghasilkan lulusan, ilmu pengetahuan, teknologi dan seni yang mampu memenuhi perubahan dinamika global.</p>
        
    </div>
    <div class="hero-image">
        <img src="{{ asset('images/education.png') }}" alt="Education Illustration">
    </div>
</section>

<section id="sertifikasi" class="section data-section">
    <div class="section-heading">
        <span>Sertifikasi</span>
        <h2>Daftar Sertifikasi</h2>
        <p>Informasi jadwal, biaya, dan pendaftaran sertifikasi yang tersedia.</p>
    </div>

    <div class="view-toggle">
        <button class="active" type="button" onclick="switchView('certification', 'calendar')"><i data-lucide="calendar-days"></i> Kalender</button>
        <button type="button" onclick="switchView('certification', 'table')"><i data-lucide="table-2"></i> Tabel</button>
    </div>

    <div class="info-bar"><i data-lucide="info"></i> View certification schedule in calendar or table format.</div>

    <div id="certification-calendar" class="view-panel">
        @include('pages.partials.calendar', ['monthTitle' => 'May 2026', 'calendarDays' => $certificationCalendar])
    </div>

    <div id="certification-table" class="view-panel hidden">
        @include('pages.partials.table', [
            'pageTitle' => 'Sertifikasi',
            'type' => 'certification',
            'columns' => ['Nama Sertifikasi','Periode Pendaftaran','Tanggal Pelatihan','Tanggal Ujian','Biaya','Jumlah Pendaftar','Daftar Sertifikasi'],
            'rows' => $certificationRows
        ])
    </div>
</section>

<section id="seminar" class="section data-section">
    <div class="section-heading">
        <span>Seminar</span>
        <h2>Daftar Seminar</h2>
        <p>Informasi seminar, webinar, dan kegiatan kampus yang sedang tersedia.</p>
    </div>

    <div class="view-toggle">
        <button class="active" type="button" onclick="switchView('seminar', 'calendar')"><i data-lucide="calendar-days"></i> Kalender</button>
        <button type="button" onclick="switchView('seminar', 'table')"><i data-lucide="table-2"></i> Tabel</button>
    </div>

    <div class="info-bar"><i data-lucide="info"></i> View seminar schedule in calendar or table format.</div>

    <div id="seminar-calendar" class="view-panel">
        @include('pages.partials.calendar', ['monthTitle' => 'May 2026', 'calendarDays' => $seminarCalendar])
    </div>

    <div id="seminar-table" class="view-panel hidden">
        @include('pages.partials.table', [
            'pageTitle' => 'Seminar',
            'type' => 'seminar',
            'columns' => ['Seminar Name','Registration Period','Seminar Date','Seminar Time','Place','Cost','Registrants','Daftar Seminar'],
            'rows' => $seminarRows
        ])
    </div>
</section>

<section id="berita" class="section news-section">
    <div class="section-heading">
        <span>Berita</span>
        <h2>Berita & Informasi</h2>
        <p>Informasi terbaru seputar seminar, sertifikasi, dan kegiatan Universitas Internasional Batam.</p>
    </div>

    <div class="news-grid">
        @foreach($news as $item)
            <article class="news-card">
                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
                <div>
                    <small>{{ $item['date'] }}</small>
                    <h3>{{ $item['title'] }}</h3>
                    <p>{{ $item['summary'] }}</p>
                    <a href="#">Baca Selengkapnya <i data-lucide="arrow-right"></i></a>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endsection

@section('footer')
@include('partials.footer')
@endsection
