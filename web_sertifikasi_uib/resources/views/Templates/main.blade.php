<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/uib.css') }}?v={{ filemtime(public_path('css/uib.css')) }}">
    
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>[data-lucide] { visibility: hidden; }</style>
</head>
<body>

    @include('templates.header')

    <main>
        @yield('content')
    </main>

    @include('templates.footer')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('js/uib.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. Inisialisasi Icon Lucide
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
                // Tampilkan icon setelah dirender
                document.querySelectorAll("[data-lucide]").forEach(el => {
                    el.style.visibility = "visible";
                });
            }

            // 2. Notifikasi SweetAlert
            @if(session('success'))
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Berhasil', 
                    text: {!! json_encode(session('success')) !!},
                    confirmButtonColor: '#3085d6' 
                });
            @endif

            @if(session('error') || $errors->any())
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Gagal', 
                    text: {!! json_encode(session('error') ?? $errors->first()) !!},
                    confirmButtonColor: '#d33'
                });
            @endif
        });
    </script>

    @yield('scripts') 
</body>
</html>