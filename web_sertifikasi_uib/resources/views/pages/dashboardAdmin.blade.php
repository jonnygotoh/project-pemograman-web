@extends('templates.main')

@section('title', 'Admin Dashboard - UIB Event')

@php($isLanding = true)

@section('content')

<!-- =========================
     ADMIN BANNER
========================= -->

<div class="admin-banner">
    <strong>Admin Panel</strong>
    <span>
        Sistem Manajemen Event Universitas Internasional Batam
    </span>
</div>

<!-- =========================
     HERO
========================= -->

<section
    id="home"
    class="section hero-section loaded-active no-select admin-hero"
>

    <!-- LEFT -->
    <div class="hero-text js-reveal">

        <span class="delay-1 admin-label">
            ADMIN DASHBOARD
        </span>

        <h1 class="delay-2">
            Selamat Datang <br>
            Admin
        </h1>

        <h2 class="delay-3">
            {{ session('admin_name') }}
        </h2>

        <p class="delay-4">
            Kelola seminar dan sertifikasi
            Universitas Internasional Batam
            dengan tampilan modern,
            cepat, dan terstruktur.
        </p>

        <div class="admin-hero-actions delay-4">

            <a href="#sertifikasi" class="btn-primary">
                Kelola Sertifikasi
            </a>

            <a href="#seminar" class="btn-outline">
                Kelola Seminar
            </a>

        </div>

        <!-- STATS -->
        <div class="dashboard-stats delay-4">

            <div class="status-card">

                <span>Seminar Aktif</span>

                <strong>
                    {{ $seminarRows->count() }}
                </strong>

            </div>

            <div class="status-card">

                <span>Sertifikasi Aktif</span>

                <strong>
                    {{ $certificationRows->count() }}
                </strong>

            </div>

            <div class="status-card">

                <span>Periode</span>

                <strong>
                    {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}
                </strong>

            </div>

        </div>

    </div>

    <!-- RIGHT -->
    <div class="hero-image js-reveal-img">

        <img
            src="{{ asset('images/education.png') }}"
            alt="Education Illustration"
            class="delay-4"
        >

    </div>

</section>

<!-- =========================
     SERTIFIKASI
========================= -->

<section
    id="sertifikasi"
    class="section data-section admin-section"
>

  <div class="section-heading js-reveal admin-heading">

    <span class="delay-1" id="left">
        Sertifikasi
    </span>

    <div class="admin-section-header">
        <div>
            <h2 class="delay-2">
                Daftar Sertifikasi
            </h2>
            <p class="admin-subtitle">
                Kelola jadwal dan data sertifikasi mahasiswa.
            </p>
        </div>
        <button
            onclick="window.location.href='{{ route('admin.sertifikasi.create') }}'"
            class="btn-primary">
            + Tambah Sertifikasi
        </button>
    </div>

    <div class="heading-line"></div>

    <!-- CALENDAR -->
    <div id="sertifikasi-calendar" class="view-panel">

        @include('pages.partials.calendar', [
            'type' => 'sertifikasi',
            'month' => $month,
            'year' => $year,
            'calendarDays' => $certificationCalendar
        ])

    </div>

</section>

<!-- =========================
     SEMINAR
========================= -->

<section
    id="seminar"
    class="section data-section admin-section"
>

    <div class="section-heading js-reveal admin-heading">

        <span class="delay-1" id="left">
            Seminar
        </span>

        <div class="admin-section-header">

            <div>

                <h2 class="delay-2">
                    Daftar Seminar
                </h2>

                <p class="admin-subtitle">
                    Atur event seminar dan aktivitas kampus.
                </p>

            </div>

            <button
                onclick="
                    window.location.href=
                    '{{ route('admin.seminar.create') }}'
                "
                class="btn-primary"
            >
                + Tambah Seminar
            </button>

        </div>

        <div class="heading-line"></div>

    </div>

    <!-- CALENDAR -->
    <div id="seminar-calendar" class="view-panel">

        @include('pages.partials.calendar', [
            'type' => 'seminar',
            'month' => $month,
            'year' => $year,
            'calendarDays' => $seminarCalendar
        ])

    </div>

</section>

@endsection