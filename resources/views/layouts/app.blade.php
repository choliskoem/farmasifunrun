<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="Himpunan Mahasiswa Jurusan Farmasi - HIMAFA"
    >

    <meta
        name="theme-color"
        content="#059669"
    >

    <title>
        {{ $title ?? 'HIMAFA — Himpunan Mahasiswa Jurusan Farmasi' }}
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body>

    @yield('content')

</body>

</html>