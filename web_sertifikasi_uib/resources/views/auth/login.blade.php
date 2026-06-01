@extends('templates.main')
@section('title', $title ?? 'Login')

@section('content')
<!-- loading sebelum user masuk -->
<div id="loader" class="loading-overlay">
    <div class="spinner"></div>
    <p style="font-weight: bold; color: #333;">Memproses data...</p>
</div>

<section class="login-page">
    <h1>{{ $title ?? 'Masuk Umum' }}</h1>
    
@if(session('success'))
    <div class="alert-success" style="padding: 10px; background: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif

    <form class="login-card" method="POST" action="{{ $action ?? route('login.process') }}">
        @csrf

        <input type="hidden" name="type" value="{{ $type ?? 'public' }}">

        @if($errors->any())
            <div class="form-error">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="input-icon">
            <i data-lucide="user"></i>
            <input name="identity" type="text" value="{{ old('identity') }}" placeholder="{{ $identityPlaceholder ?? 'Email' }}" required>
        </div>

        <div class="input-icon">
            <i data-lucide="lock-keyhole"></i>
            <input name="password" type="password" placeholder="Password" required>
        </div>

        @if(($type ?? 'public') === 'public')
            <div class="login-links">
                <span>Belum punya akun? <a href="{{ route('register.public') }}">Daftar disini</a></span>
                <a href="{{ route('password.forgot') }}">Lupa Password</a>
            </div>
        @endif

        <button class="btn-primary full">Masuk</button>
    </form>

    @if(($note ?? null))
        <div class="login-note"><i data-lucide="circle-alert"></i> Catatan : {{ $note }}</div>
    @endif
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector('form');
        const loader = document.getElementById('loader');

        if(form) {
            form.addEventListener('submit', function() {
                loader.style.display = 'flex';
            });
        }
    });
</script>
@endsection

