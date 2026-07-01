{{--
    BookVerse — Sidebar Component
    Mengikuti Design System: Modern, Minimal, Elegant, Premium, Academic
    Font: Fraunces (heading) + Inter (body)
    Warna: Primary #0EA5E9 → #0284C7 → #0369A1 | Surface #FFFFFF | Border #E3F1FB
    Icon: Heroicons Outline (inline SVG, tanpa dependency tambahan)
--}}

<aside class="relative w-72 h-screen flex flex-col bg-white border-r border-[#E3F1FB] overflow-hidden">

    {{-- Ambient background: radial glow + dot pattern (soft, tidak mengganggu) --}}
    <div class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute -top-24 -left-20 w-72 h-72 rounded-full bg-[#0EA5E9]/10 blur-3xl"></div>
        <div class="absolute bottom-0 -right-16 w-64 h-64 rounded-full bg-[#0284C7]/10 blur-3xl"></div>
        <div class="absolute inset-0 opacity-[0.35]"
             style="background-image: radial-gradient(#0EA5E9 0.6px, transparent 0.6px); background-size: 18px 18px;"></div>
    </div>

    {{-- Brand / Logo --}}
    <div class="relative z-10 flex items-center gap-3 px-6 pt-7 pb-6 mb-4">
        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-[#0EA5E9] to-[#0369A1] shadow-[0_8px_20px_-4px_rgba(14,165,233,0.45)] flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
            </svg>
        </div>
        <div class="leading-tight">
            <p class="font-[Fraunces] text-lg font-semibold text-[#0C2D3F] tracking-[-0.01em]">BookVerse</p>
            <p class="text-[11px] text-[#5B7587]">Library Management</p>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="relative z-10 flex-1 overflow-y-auto px-4 pb-6 space-y-1 font-[Inter]">

        <x-nav-link :route="'dashboard'" label="Dashboard">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
        </x-nav-link>

        {{-- Master Data --}}
        <p class="px-3 pt-5 pb-2 text-[10.5px] font-semibold uppercase tracking-wider text-[#5B7587]/70">Master Data</p>

        <x-nav-link :route="'master.books.index'" label="Buku">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
        </x-nav-link>

        <x-nav-link :route="'master.authors.index'" label="Penulis">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
        </x-nav-link>

        <x-nav-link :route="'master.publishers.index'" label="Penerbit">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
        </x-nav-link>

        <x-nav-link :route="'master.categories.index'" label="Kategori">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
        </x-nav-link>

        <x-nav-link :route="'master.shelves.index'" label="Rak">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375C2.754 3.75 2.25 4.254 2.25 4.875v1.5c0 .621.504 1.125 1.125 1.125Z" />
        </x-nav-link>

        <x-nav-link :route="'master.members.index'" label="Anggota">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
        </x-nav-link>

        <x-nav-link :route="'master.librarians.index'" label="Petugas">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </x-nav-link>

        {{-- Transaksi --}}
        <p class="px-3 pt-5 pb-2 text-[10.5px] font-semibold uppercase tracking-wider text-[#5B7587]/70">Transaksi</p>

        <x-nav-link :route="'transaction.borrowings.index'" label="Peminjaman">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
        </x-nav-link>

        <x-nav-link :route="'transaction.returns.index'" label="Pengembalian">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 0 1 0 12h-3" />
        </x-nav-link>

        <x-nav-link :route="'transaction.fines.index'" label="Denda">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3M3.75 6h16.5a1.5 1.5 0 0 1 1.5 1.5v9a1.5 1.5 0 0 1-1.5 1.5H3.75a1.5 1.5 0 0 1-1.5-1.5v-9a1.5 1.5 0 0 1 1.5-1.5Z" />
        </x-nav-link>

        <x-nav-link :route="'transaction.reservations.index'" label="Reservasi">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008Z" />
        </x-nav-link>

        {{-- Lainnya --}}
        <p class="px-3 pt-5 pb-2 text-[10.5px] font-semibold uppercase tracking-wider text-[#5B7587]/70">Lainnya</p>

        <x-nav-link :route="'reports.books'" label="Laporan">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
        </x-nav-link>

        <x-nav-link :route="'settings.edit'" label="Pengaturan">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 0 1 0 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </x-nav-link>

        <x-nav-link :route="'audit.activity-logs'" label="Audit Log">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Zm0 0c0 1.657 4.5 3 4.5 3s4.5-1.343 4.5-3-4.5-3-4.5-3-4.5 1.343-4.5 3Z" />
        </x-nav-link>

    </nav>

    {{-- Footer / user mini card --}}
    <div class="relative z-10 mx-4 mb-5 mt-2 p-3 rounded-2xl bg-[#F3F9FE] border border-[#E3F1FB] flex items-center gap-3">
        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-[#0EA5E9] to-[#0369A1] flex items-center justify-center text-white text-xs font-semibold font-[Inter]">
            {{ substr(auth()->user()->name ?? 'BV', 0, 2) }}
        </div>
        <div class="leading-tight overflow-hidden">
            <p class="text-sm font-medium text-[#0C2D3F] truncate">{{ auth()->user()->name ?? 'Pustakawan' }}</p>
            <p class="text-[11px] text-[#5B7587] truncate">{{ auth()->user()->email ?? 'admin@bookverse.test' }}</p>
        </div>
    </div>
</aside>

{{--
    ============================================================
    Blade Component: <x-nav-link>
    Simpan sebagai: resources/views/components/nav-link.blade.php
    ============================================================

    @props(['route', 'label'])
    @php
        $active = request()->routeIs($route) || request()->routeIs($route.'.*');
    @endphp

    <a href="{{ route($route) }}"
       class="group flex items-center gap-3 px-4 py-2.5 rounded-full text-sm font-medium transition-all duration-200 ease-out
              {{ $active
                    ? 'bg-gradient-to-r from-[#0EA5E9] to-[#0284C7] text-white shadow-[0_10px_20px_-8px_rgba(14,165,233,0.55)]'
                    : 'text-[#5B7587] hover:bg-[#F3F9FE] hover:text-[#0C2D3F] hover:-translate-y-0.5' }}">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-5 h-5 shrink-0 {{ $active ? 'text-white' : 'text-[#5B7587] group-hover:text-[#0EA5E9]' }} transition-colors"
             fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
            {{ $slot }}
        </svg>
        <span>{{ $label }}</span>
    </a>
--}}
