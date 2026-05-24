@extends('templates.main')
@section('title', $title ?? 'Login')

@section('content')
<section class="login-page">
    <h1>{{ $title ?? 'Masuk Umum' }}</h1>
    

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
                <span>Belum punya akun? <a href="#">Daftar disini</a></span>
                <a href="#">Lupa Password</a>
            </div>
        @endif

        <button class="btn-primary full">Masuk</button>
    </form>

    @if(($note ?? null))
        <div class="login-note"><i data-lucide="circle-alert"></i> Catatan : {{ $note }}</div>
    @endif
</section>
@endsection


