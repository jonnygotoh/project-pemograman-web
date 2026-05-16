<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UIB Event')</title>

    <link rel="stylesheet" href="{{ asset('css/uib.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @yield('footer')

    @include('components.modal')

    <script src="{{ asset('js/uib.js') }}"></script>
    @stack('scripts')
</body>
</html>
