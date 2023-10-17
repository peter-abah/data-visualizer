<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Data Visualizer') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
        rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div
        class="flex min-h-screen flex-col items-center pt-6 justify-center sm:pt-0">
        <div class="grid place-items-center">
            <h1 class="text-8xl font-bold mb-6">404.</h1>
            <p></p>
            <a class="text-xl px-8 py-2 bg-black text-white" href="/">Back to home</a>
        </div>
    </div>
</body>

</html>
