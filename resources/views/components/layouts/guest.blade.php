<!DOCTYPE html>
<html lang="id" class="bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Masuk - Adibah Shop' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center">
    {{ $slot }}
    @livewireScripts
</body>
</html>