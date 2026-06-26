<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sistem Bansos Desa' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">

    <x-navbar />

    @isset($header)
    <div class="bg-white border-b border-gray-100 px-6 py-4">
        <div class="max-w-7xl mx-auto">
            {{ $header }}
        </div>
    </div>
    @endisset

    {{ $slot }}

    <x-footer />

</body>

</html>