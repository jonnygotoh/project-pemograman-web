@extends('templates.main')
@section('title', 'Reset Password')

@section('content')
<section class="login-page">
    <h1>Reset Password</h1>
    
    <form class="login-card" method="POST" action="{{ route('password.reset.process') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        
        <div class="input-icon">
            <i data-lucide="lock-keyhole"></i>
            <input name="password" type="password" placeholder="Password Baru" required>
        </div>
        <button class="btn-primary full">Ganti Password</button>
    </form> </section>
@endsection