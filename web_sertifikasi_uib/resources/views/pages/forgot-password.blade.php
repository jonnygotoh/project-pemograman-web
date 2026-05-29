@extends('templates.main')
@section('title', 'Lupa Password')

@section('content')
<section class="login-page">
    <h1>Lupa Password</h1>
    <form class="login-card" method="POST" action="{{ route('password.check') }}">
        @csrf
        
        @if($errors->any())
            <div class="form-error" style="color: red; margin-bottom: 10px;">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="input-icon">
            <i data-lucide="mail"></i>
            <input name="email" type="email" placeholder="Masukkan Email Anda" required>
        </div>
        <button class="btn-primary full">Cari Akun</button>
    </form>
</section>
@endsection