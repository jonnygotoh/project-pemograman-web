@extends('templates.main')

@section('title', 'Admin Dashboard - UIB Event')

@php($isLanding = true)

@section('content')

<div class="admin-banner">
    <strong>Admin Panel</strong>
    <span>Sistem Manajemen Event Universitas Internasional Batam</span>
</div>

<section id="home" class="section hero-section loaded-active no-select admin-hero">
    <div class="hero-text js-reveal">
        <span class="delay-1 admin-label">ADMIN DASHBOARD</span>
        <h1 class="delay-2">Selamat Datang <br> Admin</h1>
        <h2 class="delay-3">{{ session('admin_name') }}</h2>
        <p class="delay-4">
            Kelola seminar dan sertifikasi Universitas Internasional Batam
            dengan tampilan modern, cepat, dan terstruktur.
        </p>
        <div class="admin-hero-actions delay-4">
            <a href="#sertifikasi" class="btn-primary">Kelola Sertifikasi</a>
            <a href="#seminar" class="btn-outline">Kelola Seminar</a>
        </div>
        <div class="dashboard-stats delay-4">
            <div class="status-card">
                <span>Seminar Aktif</span>
                <strong>{{ $seminarRows->count() }}</strong>
            </div>
            <div class="status-card">
                <span>Sertifikasi Aktif</span>
                <strong>{{ $certificationRows->count() }}</strong>
            </div>
            <div class="status-card">
                <span>Periode</span>
                <strong>{{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}</strong>
            </div>
        </div>
    </div>
    <div class="hero-image js-reveal-img">
        <img src="{{ asset('images/education.png') }}" alt="Education Illustration" class="delay-4">
    </div>
</section>

{{-- SECTION SERTIFIKASI --}}
<section id="sertifikasi" class="section data-section admin-section">
    <div class="section-heading js-reveal admin-heading">
        <span class="delay-1" id="left">Sertifikasi</span>
        <div class="admin-section-header">
            <div>
                <h2 class="delay-2" id="down">Daftar Sertifikasi</h2>
                <p class="admin-subtitle" id="down">Kelola jadwal dan data sertifikasi mahasiswa.</p>
            </div>
            <button onclick="window.location.href='{{ route('admin.sertifikasi.create') }}'" class="btn-primary">
                + Tambah Sertifikasi
            </button>
        </div>
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

{{-- SECTION SEMINAR --}}
<section id="seminar" class="section data-section admin-section">
    <div class="section-heading js-reveal admin-heading">
        <span class="delay-1" id="left">Seminar</span>
        <div class="admin-section-header">
            <div>
                <h2 class="delay-2">Daftar Seminar</h2>
                <p class="admin-subtitle">Atur event seminar dan aktivitas kampus.</p>
            </div>
            <button onclick="window.location.href='{{ route('admin.seminar.create') }}'" class="btn-primary">
                + Tambah Seminar
            </button>
        </div>
        <div class="heading-line"></div>
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
            // Hapus 'Biaya' dari array columns
            'columns' => ['No', 'Nama', 'Periode', 'Tanggal', 'Waktu', 'Pendaftar'],
            'rows' => $seminarRows
        ])
    </div>
</section>

{{-- SECTION PEMBAYARAN --}}
<section id="pembayaran" class="section data-section admin-section">
    <div class="section-heading js-reveal admin-heading">
        <span class="delay-1" id="left">Pembayaran</span>
        <h2 class="delay-2">Verifikasi Pembayaran</h2>
        <div class="heading-line"></div>
    </div>
    <div class="view-panel">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User ID</th>
                    <th>Tipe</th>
                    <th>Bukti Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembayaranMenunggu as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->user_id }}</td>
                    <td>{{ ucfirst($item->user_type) }}</td>
                    <td><a href="{{ asset('storage/bukti_bayar/' . $item->bukti_bayar) }}" target="_blank" class="btn-outline">Lihat Bukti</a></td>
                    <td>
                        <form action="{{ route('admin.verifikasi.pembayaran', $item->id) }}" method="POST" onsubmit="return confirm('Simpan data ini?')">
                            @csrf
                            <select name="status" class="form-input" style="display: block; margin-bottom: 5px;">
                                <option value="lunas">Lunas</option>
                                <option value="ditolak">Tolak</option>
                            </select>
                            <input type="number" name="skor" placeholder="Input Skor (0-100)" class="form-input" min="0" max="100" style="display: block; margin-bottom: 5px;">
                            <input type="text" name="catatan_admin" placeholder="Catatan" class="form-input" style="display: block; margin-bottom: 5px;">
                            <button type="submit" class="btn-primary">Simpan</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align: center;">Tidak ada pembayaran yang perlu diverifikasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@endsection