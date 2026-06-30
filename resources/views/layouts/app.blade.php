<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookVerse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex">
    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-lg">
        @include('components.sidebar')
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Navbar -->
        <nav class="bg-white shadow-sm">
            @include('components.navbar')
        </nav>

        <!-- Content -->
        <main class="flex-1 p-6 overflow-auto">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t">
            @include('components.footer')
        </footer>
    </div>
</body>
</html>