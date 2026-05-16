@php
    $isLanding = $isLanding ?? false;
@endphp

<header class="navbar">
    <a href="{{ $isLanding ? '#home' : route('home') }}" class="brand js-scroll-link">
        <img src="{{ asset('images/logo-uib.png') }}" alt="UIB">
        <span>UNIVERSITAS<br>INTERNASIONAL<br>BATAM</span>
    </a>

    <button class="mobile-menu-btn" type="button" onclick="toggleDropdown('navMenu')">
        <i data-lucide="menu"></i>
    </button>

    <nav id="navMenu" class="nav-menu">
        @if($isLanding)
            <a class="js-scroll-link active" href="#home">Beranda</a>
            <a class="js-scroll-link" href="#sertifikasi">Sertifikasi</a>
            <a class="js-scroll-link" href="#seminar">Seminar</a>
            <a class="js-scroll-link" href="#berita">Berita</a>
        @else
            <a href="{{ route('home') }}#home">Beranda</a>
            <a href="{{ route('home') }}#sertifikasi">Sertifikasi</a>
            <a href="{{ route('home') }}#seminar">Seminar</a>
            <a href="{{ route('home') }}#berita">Berita</a>
        @endif

        @auth
            <div class="account-wrap">
                <button class="account-btn" type="button" onclick="toggleDropdown('accountMenu')">
                    <i data-lucide="user"></i> Akun <i data-lucide="chevron-down"></i>
                </button>
                <div id="accountMenu" class="account-dropdown">
                    <div class="account-name"><i data-lucide="circle-user-round"></i> {{ auth()->user()->name ?? 'Your Full Name' }}</div>
                    <hr>
                    <a href="{{ route('profile') }}"><i data-lucide="user-round"></i> Profile</a>
                    <a href="{{ route('logout') }}"><i data-lucide="log-out"></i> Logout</a>
                </div>
            </div>
        @else
            <a class="login-pill" href="{{ route('login.choose') }}">Masuk</a>
        @endauth
    </nav>
</header>
