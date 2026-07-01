{{-- Navbar untuk halaman publik (landing, katalog, auth) --}}
<header class="border-b">
    <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
        <a href="{{ route('beranda') }}" class="font-bold text-xl">BookVerse</a>

        <nav class="flex items-center gap-6">
            <a href="{{ route('public.books.index') }}">Daftar Buku</a>
            <a href="{{ route('public.profile') }}">Profil</a>
            <a href="{{ route('public.contact') }}">Kontak</a>

            @auth
                <a href="{{ route('dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Daftar</a>
            @endauth
        </nav>
    </div>
</header>
