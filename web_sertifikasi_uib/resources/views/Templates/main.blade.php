<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

      <link
        rel="stylesheet"
        href="{{ asset('css/style.css') }}"
        >

</head>
<body>

    @include('Templates.header')
<!-- membuat halaman yang tidak perlu di ubah -->

<nav class="navbar">

    <div class="navbar-left">

        <img
            src="{{ asset('images/logo-uib.png') }}"
            alt="UIB"
            class="logo"
        >

        <div class="logo-text">

            <h2>
                UNIVERSITAS <br>
                INTERNASIONAL <br>
                BATAM
            </h2>

        </div>

    </div>

    <ul class="navbar-menu">

        <li>
            <a href="#">
                Beranda
            </a>
        </li>

        <li>
            <a href="#">
                Sertifikasi
            </a>
        </li>

        <li>
            <a href="#">
                Seminar
            </a>
        </li>

        <li>
            <a href="#">
                Berita
            </a>
        </li>

    </ul>

    <button class="login-btn">
        Masuk
    </button>

</nav>

    <main>
        @yield('content')
    </main>

    @include('Templates.footer')

    <script src="{{ asset('js/script.js') }}"></script>
        
</body>
</html>
