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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // JIKA LOGIN / PROSES BERHASIL
            @if(session('success'))
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Berhasil', 
                    text: @json(session('success')),
                    showConfirmButton: true, 
                    confirmButtonColor: '#3085d6', 
                    confirmButtonText: 'OK' 
                });
            @endif

            // JIKA LOGIN / PROSES GAGAL
            @if(session('error') || $errors->any())
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Gagal', 
                    text: @json(session('error') ?? $errors->first()),
                    showConfirmButton: true,
                    confirmButtonColor: '#d33', // <-- Warna merah untuk tombol OK gagal
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>

    @yield('scripts') 
</body>
</html>