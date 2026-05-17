<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet"href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/uib.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>

    @include('Templates.header')
<!-- membuat halaman yang tidak perlu di ubah -->

    <main>
        @yield('content')
        <div class="hero-left">

            <h1>
                Selamat Datang
            </h1>

            <h2>
                Universitas Internasional Batam
            </h2>

            <p>
                Universitas dengan standar mutu internasional
                yang menghasilkan lulusan, ilmu pengetahuan,
                teknologi dan seni yang mampu memenuhi
                perubahan dinamika global.
            </p>

        </div>

        <div class="hero-right">

            <img
                src="{{ asset('images/education.png') }}"
                alt="Hero"
            >

        </div>
    </main>

    @include('Templates.footer')
    @include('Templates.alert')

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/uib.js') }}"></script>
    @stack('scripts')

</body>
</html>
