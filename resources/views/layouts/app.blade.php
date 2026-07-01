<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BookVerse') — BookVerse</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">

        @include('partials.sidebar')

        <div class="flex-1 flex flex-col">

            @include('partials.navbar')

            <main class="flex-1 p-6">
                @include('partials.alerts')

                @yield('content')
            </main>

            @include('partials.footer')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
