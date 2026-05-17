@extends('templates.main')
@section('title', 'Pilih Login')

@section('content')
<section class="login-choice-page">
    <h1>Selamat Datang di UIB</h1>
    <p>Silakan pilih jenis akun untuk melanjutkan</p>

    <div class="choice-grid">
        <a href="{{ route('login.student') }}" class="choice-card">
            <div class="choice-icon"><i data-lucide="graduation-cap"></i></div>
            <h3>Masuk sebagai Mahasiswa</h3>
            <span></span>
            <p>Akses seminar dan sertifikasi yang tersedia untuk mahasiswa.</p>
            <button>Masuk sebagai Mahasiswa <i data-lucide="arrow-right"></i></button>
        </a>

        <a href="{{ route('login.public') }}" class="choice-card">
            <div class="choice-icon"><i data-lucide="user-round"></i></div>
            <h3>Masuk sebagai Umum</h3>
            <span></span>
            <p>Daftar dan ikuti berbagai seminar publik dan event menarik.</p>
            <button>Masuk sebagai Umum <i data-lucide="arrow-right"></i></button>
        </a>

        <a href="{{ route('login.lecturer') }}" class="choice-card">
            <div class="choice-icon"><i data-lucide="presentation"></i></div>
            <h3>Masuk sebagai Dosen UIB</h3>
            <span></span>
            <p>Kelola seminar dan sertifikasi untuk mahasiswa dan publik.</p>
            <button>Masuk sebagai Dosen UIB <i data-lucide="arrow-right"></i></button>
        </a>
    </div>
</section>
@endsection

@section('footer')
@include('templates.footer')
@endsection
