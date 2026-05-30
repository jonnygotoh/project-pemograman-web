@php
    $isLanding = $isLanding ?? false;
@endphp

<header class="navbar no-select">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <a href="{{ $isLanding ? '#home' : route('home') }}"
        class="brand {{ $isLanding ? 'js-scroll-link' : '' }}">
        <img src="{{ asset('images/logo-uib.png') }}" alt="Logo">
        <span>UNIVERSITAS<br>INTERNASIONAL<br>BATAM</span>
    </a>

    <button class="mobile-menu-btn" type="button"
        onclick="toggleDropdown('navMenu')">
        <i data-lucide="menu"></i>
    </button>

    <nav id="navMenu" class="nav-menu">

        @if($isLanding)

            <a class="js-scroll-link active" href="#home">Beranda</a>
            <a class="js-scroll-link" href="#sertifikasi">Sertifikasi</a>
            <a class="js-scroll-link" href="#seminar">Seminar</a>

        @else

            <a class="js-scroll-link" href="{{ route('home') }}#home">Beranda</a>
            <a class="js-scroll-link" href="{{ route('home') }}#sertifikasi">Sertifikasi</a>
            <a class="js-scroll-link" href="{{ route('home') }}#seminar">Seminar</a>

        @endif

        @php
            $currentUser = auth()->check() ? auth()->user() : session('auth_user');
        @endphp
        
        @if($currentUser)
            <div class="account-wrap">
                <button class="account-btn" onclick="toggleDropdown('accountMenu')">
                    <i data-lucide="user"></i> Akun
                </button>

                <div id="accountMenu" class="account-dropdown">
                    <div class="account-name">
                        <a href="{{ route('profile') }}">
                            {{ is_array($currentUser) ? $currentUser['name'] : ($currentUser->name ?? 'User') }}
                        </a>
                    </div>
                     
                    <a href="{{ route('logout') }}">Logout</a>
                </div>
            </div>

       @elseif(session()->has('admin_id') && request()->is('admin/*'))
            <div class="account-wrap">
                <button class="account-btn" onclick="toggleDropdown('adminMenu')">
                    <i data-lucide="shield-check"></i> Admin
                </button>
                <div id="adminMenu" class="account-dropdown">
                    <a href="{{ route('logout.admin') }}" style="color: #dc3545;">Logout Admin</a>
                </div>
            </div>
        @else
            <a class="login-pill" href="{{ route('login.choose') }}">Masuk</a>
        @endif

    </nav>

</header>