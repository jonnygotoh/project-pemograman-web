<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/uib.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>

    @include('templates.header')

    <main>
        @yield('content')
    </main>

    @include('templates.footer')

<script src="{{ asset('js/uib.js') }}" defer></script>

</body>
</html>