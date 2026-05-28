@extends('templates.main')

@section('title', 'Login Admin')

@section('content')
<section class="login-page">

    <h1>Login Admin</h1>

    @if(session('error'))
        <div class="form-error">
            {{ session('error') }}
        </div>
    @endif

    <form class="login-card" method="POST" action="/admin">
        @csrf

        <div class="input-icon">
            <i data-lucide="user"></i>
            <input
                name="username"
                type="text"
                placeholder="Username Admin"
                required
            >
        </div>

        <div class="input-icon">
            <i data-lucide="lock-keyhole"></i>
            <input
                name="password"
                type="password"
                placeholder="Password"
                required
            >
        </div>

        <button class="btn-primary full" type="submit">
            Masuk Admin
        </button>
    </form>

</section>
@endsection