{{-- Navbar untuk layout dashboard (admin/petugas/anggota) --}}
<header class="h-16 flex items-center justify-between px-6 bg-white border-b">
    <div class="font-semibold text-gray-700">@yield('page-title', 'Dashboard')</div>

    <div class="flex items-center gap-4">
        {{-- TODO: dropdown notifikasi, panggil route('notifications.recent') via AJAX --}}
        <div id="notification-dropdown"></div>

        <div class="flex items-center gap-2">
            <span>{{ auth()->user()->name ?? 'Guest' }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</header>
