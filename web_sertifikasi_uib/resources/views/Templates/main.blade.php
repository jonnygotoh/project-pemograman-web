<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
</head>
<body>

    @include(Templates.header)
<!-- membuat halaman yang tidak perlu di ubah -->
    <main>
        @yield('content')
    </main>

    @include(Templates.footer)

</body>
</html>