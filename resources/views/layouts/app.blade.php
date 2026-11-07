<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Perpustakaan Kita')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-100 text-slate-800">
    <div class="min-h-screen">

        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white border-b border-slate-200 shadow-sm">
                <div class="max-w-7xl mx-auto py-6 px-6">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="py-8">
            @yield('content')
            {{ $slot ?? '' }}
        </main>

        <footer class="bg-white border-t border-slate-200 mt-12">
            <div class="max-w-7xl mx-auto px-6 py-5 text-center">
                <p class="text-sm text-slate-500">
                    © {{ date('Y') }} Perpustakaan Kita.
                    Temukan cerita yang ingin kamu baca.
                </p>
            </div>
        </footer>

    </div>
</body>
</html>
