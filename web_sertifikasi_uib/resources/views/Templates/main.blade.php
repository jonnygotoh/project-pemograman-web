<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

      <script src="https://unpkg.com/lucide@latest"></script>
      <link rel="stylesheet" href="{{ asset('css/uib.css') }}">
</head>
<body>

    @include('templates.header')
<!-- membuat halaman yang tidak perlu di ubah -->

    <main>
        @yield('content')
    </main>

    @include('templates.footer')

<script src="{{ asset('js/uib.js') }}" defer></script>        
</body>
</html>
