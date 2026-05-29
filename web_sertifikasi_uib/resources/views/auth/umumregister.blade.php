@extends('templates.main')
@section('title', 'Daftar Akun Umum')

@section('content')
<section class="login-page">
    <h1>Daftar Akun</h1>
    
    <form class="login-card" method="POST" action="{{ route('register.process') }}">
        @csrf
        
        <div class="input-icon">
            <i data-lucide="user"></i>
            <input name="nama" type="text" placeholder="Nama Lengkap" required>
        </div>

        <div class="input-icon">
            <i data-lucide="mail"></i>
            <input name="email" type="email" placeholder="Email" required>
        </div>

        <div class="input-icon">
            <i data-lucide="phone"></i>
            <input name="no_hp" type="text" placeholder="Nomor HP">
        </div>

        <div class="input-icon">
            <i data-lucide="lock-keyhole"></i>
            <input name="password" type="password" placeholder="Password" required>
        </div>

        <button class="btn-primary full">Daftar Sekarang</button>
    </form>
</section>
@endsection