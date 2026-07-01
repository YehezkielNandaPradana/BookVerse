{{-- 
    BookVerse Sidebar
    ─────────────────
    Pastikan di layout utama sudah load font:
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    Pastikan main content wrapper memiliki class: lg:ml-72
    Contoh: <main class="lg:ml-72 min-h-screen ...">
--}}

@php
    // ── Role Helper ──────────────────────────────────
    $role      = auth()->user()->role ?? 'anggota';
    $isAdmin   = $role === 'admin';
    $isPetugas = in_array($role, ['admin', 'petugas']);

    // ── Active State Helper ──────────────────────────
    $isActive      = fn($route) => request()->routeIs($route);
    $isGroupActive = fn($routes) => collect($routes)->contains(fn($r) => request()->routeIs($r));

    // ── Group Active States ──────────────────────────
    $masterRoutes = [
        'master.books.index', 'master.authors.index', 'master.publishers.index',
        'master.categories.index', 'master.shelves.index', 'master.members.index',
        'master.librarians.index',
    ];
    $transaksiRoutes = [
        'transaction.borrowings.index', 'transaction.returns.index',
        'transaction.fines.index', 'transaction.reservations.index',
    ];
    $lainnyaRoutes = [
        'reports.books', 'settings.edit', 'audit.activity-logs',
    ];

    $masterActive   = $isGroupActive($masterRoutes);
    $transaksiActive = $isGroupActive($transaksiRoutes);
    $lainnyaActive  = $isGroupActive($lainnyaRoutes);
@endphp

{{-- ══════════════════════════════════════════════════════════
     Mobile Overlay
     ══════════════════════════════════════════════════════════ --}}
<div id="sidebar-overlay"
     class="fixed inset-0 z-40 bg-black/20 backdrop-blur-sm lg:hidden opacity-0 pointer-events-none transition-opacity duration-300"
     onclick="toggleSidebar()">
</div>

{{-- ══════════════════════════════════════════════════════════
     Mobile Toggle Button (tempatkan di navbar untuk posisi terbaik)
     ══════════════════════════════════════════════════════════ --}}
<button id="sidebar-toggle"
        onclick="toggleSidebar()"
        class="fixed top-5 left-5 z-[60] lg:hidden w-10 h-10 bg-white rounded-2xl border border-[#E3F1FB] shadow-[0_2px_12px_rgba(14,165,233,0.08)] flex items-center justify-center text-[#5B7587] hover:text-[#0EA5E9] hover:shadow-[0_4px_16px_rgba(14,165,233,0.15)] transition-all duration-300">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
    </svg>
</button>

{{-- ══════════════════════════════════════════════════════════
     Sidebar
     ══════════════════════════════════════════════════════════ --}}
<aside id="sidebar"
       class="fixed top-0 left-0 z-50 h-screen w-72 bg-white border-r border-[#E3F1FB] shadow-[0_8px_40px_rgba(14,165,233,0.06)] flex flex-col transition-transform duration-300 ease-out lg:translate-x-0 -translate-x-full">

    {{-- ── Top Accent Line ────────────────────────────── --}}
    <div class="h-1 w-full bg-gradient-to-r from-[#0EA5E9] via-[#0284C7] to-[#0369A1] flex-shrink-0"></div>

    {{-- ── Brand ──────────────────────────────────────── --}}
    <div class="px-6 pt-6 pb-5 flex-shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 bg-gradient-to-br from-[#0EA5E9] to-[#0369A1] rounded-2xl flex items-center justify-center shadow-[0_4px_14px_rgba(14,165,233,0.3)] group-hover:shadow-[0_6px_20px_rgba(14,165,233,0.4)] group-hover:-translate-y-0.5 transition-all duration-300">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
            <span class="font-['Fraunces'] text-xl font-semibold text-[#0C2D3F] tracking-tight">BookVerse</span>
        </a>
    </div>

    {{-- ── Navigation (Scrollable) ───────────────────── --}}
    <nav class="sidebar-nav flex-1 overflow-y-auto px-3 pb-4">

        {{-- ─── Dashboard ──────────────────────────── --}}
        <a href="{{ route('dashboard') }}"
           class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-2xl text-sm font-medium transition-all duration-200
                  {{ $isActive('dashboard')
                      ? 'bg-[#0EA5E9]/10 text-[#0284C7] shadow-[0_2px_8px_rgba(14,165,233,0.1)]'
                      : 'text-[#5B7587] hover:bg-[#F3F9FE] hover:text-[#0C2D3F]' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            <span>Dashboard</span>
        </a>

        {{-- ─── Section: Master Data ───────────────── --}}
        @if($isPetugas)
        <div class="mt-6">
            <button onclick="toggleSection('master')"
                    class="flex items-center justify-between w-full px-3 py-1.5 text-[11px] font-semibold text-[#5B7587]/40 uppercase tracking-[0.12em] hover:text-[#5B7587]/60 transition-colors duration-200">
                <span>Master Data</span>
                <svg id="chevron-master"
                     class="w-3.5 h-3.5 transition-transform duration-300 {{ $masterActive ? 'rotate-180' : '' }}"
                     fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <div id="section-master" class="section-content {{ $masterActive ? 'open' : '' }}">
                <div class="space-y-0.5 pt-1.5 pb-1">

                    {{-- Buku --}}
                    @if($isAdmin || $isPetugas)
                    <a href="{{ route('master.books.index') }}"
                       class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-medium transition-all duration-200
                              {{ $isActive('master.books.index')
                                  ? 'bg-[#0EA5E9]/10 text-[#0284C7]'
                                  : 'text-[#5B7587] hover:bg-[#F3F9FE] hover:text-[#0C2D3F]' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                        <span>Buku</span>
                    </a>
                    @endif

                    {{-- Penulis --}}
                    @if($isAdmin || $isPetugas)
                    <a href="{{ route('master.authors.index') }}"
                       class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-medium transition-all duration-200
                              {{ $isActive('master.authors.index')
                                  ? 'bg-[#0EA5E9]/10 text-[#0284C7]'
                                  : 'text-[#5B7587] hover:bg-[#F3F9FE] hover:text-[#0C2D3F]' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                        <span>Penulis</span>
                    </a>
                    @endif

                    {{-- Penerbit --}}
                    @if($isAdmin || $isPetugas)
                    <a href="{{ route('master.publishers.index') }}"
                       class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-medium transition-all duration-200
                              {{ $isActive('master.publishers.index')
                                  ? 'bg-[#0EA5E9]/10 text-[#0284C7]'
                                  : 'text-[#5B7587] hover:bg-[#F3F9FE] hover:text-[#0C2D3F]' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                        </svg>
                        <span>Penerbit</span>
                    </a>
                    @endif

                    {{-- Kategori --}}
                    <a href="{{ route('master.categories.index') }}"
                       class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-medium transition-all duration-200
                              {{ $isActive('master.categories.index')
                                  ? 'bg-[#0EA5E9]/10 text-[#0284C7]'
                                  : 'text-[#5B7587] hover:bg-[#F3F9FE] hover:text-[#0C2D3F]' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25a2.25 2.25 0 0 1-2.25-2.25v-2.25Z" />
                        </svg>
                        <span>Kategori</span>
                    </a>

                    {{-- Rak --}}
                    @if($isAdmin || $isPetugas)
                    <a href="{{ route('master.shelves.index') }}"
                       class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-medium transition-all duration-200
                              {{ $isActive('master.shelves.index')
                                  ? 'bg-[#0EA5E9]/10 text-[#0284C7]'
                                  : 'text-[#5B7587] hover:bg-[#F3F9FE] hover:text-[#0C2D3F]' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                        <span>Rak</span>
                    </a>
                    @endif

                    {{-- Anggota --}}
                    @if($isAdmin || $isPetugas)
                    <a href="{{ route('master.members.index') }}"
                       class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-medium transition-all duration-200
                              {{ $isActive('master.members.index')
                                  ? 'bg-[#0EA5E9]/10 text-[#0284C7]'
                                  : 'text-[#5B7587] hover:bg-[#F3F9FE] hover:text-[#0C2D3F]' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                        <span>Anggota</span>
                    </a>
                    @endif

                    {{-- Petugas (Admin Only) --}}
                    @if($isAdmin)
                    <a href="{{ route('master.librarians.index') }}"
                       class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-medium transition-all duration-200
                              {{ $isActive('master.librarians.index')
                                  ? 'bg-[#0EA5E9]/10 text-[#0284C7]'
                                  : 'text-[#5B7587] hover:bg-[#F3F9FE] hover:text-[#0C2D3F]' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                        <span>Petugas</span>
                    </a>
                    @endif

                </div>
            </div>
        </div>
        @endif

        {{-- ─── Section: Transaksi ─────────────────── --}}
        <div class="mt-6">
            <button onclick="toggleSection('transaksi')"
                    class="flex items-center justify-between w-full px-3 py-1.5 text-[11px] font-semibold text-[#5B7587]/40 uppercase tracking-[0.12em] hover:text-[#5B7587]/60 transition-colors duration-200">
                <span>Transaksi</span>
                <svg id="chevron-transaksi"
                     class="w-3.5 h-3.5 transition-transform duration-300 {{ $transaksiActive ? 'rotate-180' : '' }}"
                     fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <div id="section-transaksi" class="section-content {{ $transaksiActive ? 'open' : '' }}">
                <div class="space-y-0.5 pt-1.5 pb-1">

                    {{-- Peminjaman --}}
                    <a href="{{ route('transaction.borrowings.index') }}"
                       class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-medium transition-all duration-200
                              {{ $isActive('transaction.borrowings.index')
                                  ? 'bg-[#0EA5E9]/10 text-[#0284C7]'
                                  : 'text-[#5B7587] hover:bg-[#F3F9FE] hover:text-[#0C2D3F]' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                        <span>Peminjaman</span>
                    </a>

                    {{-- Pengembalian --}}
                    <a href="{{ route('transaction.returns.index') }}"
                       class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-medium transition-all duration-200
                              {{ $isActive('transaction.returns.index')
                                  ? 'bg-[#0EA5E9]/10 text-[#0284C7]'
                                  : 'text-[#5B7587] hover:bg-[#F3F9FE] hover:text-[#0C2D3F]' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                        </svg>
                        <span>Pengembalian</span>
                    </a>

                    {{-- Denda --}}
                    @if($isAdmin || $isPetugas)
                    <a href="{{ route('transaction.fines.index') }}"
                       class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-medium transition-all duration-200
                              {{ $isActive('transaction.fines.index')
                                  ? 'bg-[#0EA5E9]/10 text-[#0284C7]'
                                  : 'text-[#5B7587] hover:bg-[#F3F9FE] hover:text-[#0C2D3F]' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                        </svg>
                        <span>Denda</span>
                    </a>
                    @endif

                    {{-- Reservasi --}}
                    <a href="{{ route('transaction.reservations.index') }}"
                       class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-medium transition-all duration-200
                              {{ $isActive('transaction.reservations.index')
                                  ? 'bg-[#0EA5E9]/10 text-[#0284C7]'
                                  : 'text-[#5B7587] hover:bg-[#F3F9FE] hover:text-[#0C2D3F]' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                        </svg>
                        <span>Reservasi</span>
                    </a>

                </div>
            </div>
        </div>

        {{-- ─── Section: Lainnya ───────────────────── --}}
        @if($isAdmin)
        <div class="mt-6">
            <button onclick="toggleSection('lainnya')"
                    class="flex items-center justify-between w-full px-3 py-1.5 text-[11px] font-semibold text-[#5B7587]/40 uppercase tracking-[0.12em] hover:text-[#5B7587]/60 transition-colors duration-200">
                <span>Lainnya</span>
                <svg id="chevron-lainnya"
                     class="w-3.5 h-3.5 transition-transform duration-300 {{ $lainnyaActive ? 'rotate-180' : '' }}"
                     fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <div id="section-lainnya" class="section-content {{ $lainnyaActive ? 'open' : '' }}">
                <div class="space-y-0.5 pt-1.5 pb-1">

                    {{-- Laporan --}}
                    <a href="{{ route('reports.books') }}"
                       class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-medium transition-all duration-200
                              {{ $isActive('reports.books')
                                  ? 'bg-[#0EA5E9]/10 text-[#0284C7]'
                                  : 'text-[#5B7587] hover:bg-[#F3F9FE] hover:text-[#0C2D3F]' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                        <span>Laporan</span>
                    </a>

                    {{-- Pengaturan --}}
                    <a href="{{ route('settings.edit') }}"
                       class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-medium transition-all duration-200
                              {{ $isActive('settings.edit')
                                  ? 'bg-[#0EA5E9]/10 text-[#0284C7]'
                                  : 'text-[#5B7587] hover:bg-[#F3F9FE] hover:text-[#0C2D3F]' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <span>Pengaturan</span>
                    </a>

                    {{-- Audit Log --}}
                    <a href="{{ route('audit.activity-logs') }}"
                       class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-medium transition-all duration-200
                              {{ $isActive('audit.activity-logs')
                                  ? 'bg-[#0EA5E9]/10 text-[#0284C7]'
                                  : 'text-[#5B7587] hover:bg-[#F3F9FE] hover:text-[#0C2D3F]' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>Audit Log</span>
                    </a>

                </div>
            </div>
        </div>
        @endif

        {{-- ── Scroll Fade Indicator ─────────────────── --}}
        <div class="h-8 bg-gradient-to-t from-white to-transparent pointer-events-none -mt-8 relative z-10"></div>

    </nav>

    {{-- ── User Section (Bottom) ─────────────────────── --}}
    <div class="flex-shrink-0 px-5 py-4 border-t border-[#E3F1FB] bg-white">
        <div class="flex items-center gap-3">
            {{-- Avatar --}}
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-[#0EA5E9] to-[#0369A1] flex items-center justify-center text-white text-sm font-semibold shadow-[0_2px_8px_rgba(14,165,233,0.25)] flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-[#0C2D3F] truncate leading-tight">
                    {{ auth()->user()->name ?? 'User' }}
                </p>
                <p class="text-[11px] text-[#5B7587]/60 truncate leading-tight mt-0.5 capitalize">
                    {{ $role }}
                </p>
            </div>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                @csrf
                <button type="submit"
                        class="p-2 -mr-1 rounded-xl text-[#5B7587]/50 hover:text-[#EF4444] hover:bg-red-50 transition-all duration-200"
                        title="Keluar">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

</aside>

{{-- ══════════════════════════════════════════════════════════
     Styles & Scripts
     ══════════════════════════════════════════════════════════ --}}
@push('styles')
<style>
    /* ── Section Collapse Animation (CSS Grid trick) ─── */
    .section-content {
        display: grid;
        grid-template-rows: 0fr;
        transition: grid-template-rows 300ms cubic-bezier(0.4, 0, 0.2, 1);
    }
    .section-content.open {
        grid-template-rows: 1fr;
    }
    .section-content > div {
        overflow: hidden;
    }

    /* ── Sidebar Link Hover Lift ─────────────────────── */
    .sidebar-link {
        position: relative;
    }
    .sidebar-link:not(.bg-\[\#0EA5E9\]\/10):hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(14, 165, 233, 0.04);
    }

    /* ── Active Left Indicator ───────────────────────── */
    .sidebar-link.bg-\[\#0EA5E9\]\/10::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 60%;
        background: linear-gradient(to bottom, #0EA5E9, #0284C7);
        border-radius: 0 4px 4px 0;
    }

    /* ── Custom Scrollbar ────────────────────────────── */
    .sidebar-nav::-webkit-scrollbar {
        width: 4px;
    }
    .sidebar-nav::-webkit-scrollbar-track {
        background: transparent;
    }
    .sidebar-nav::-webkit-scrollbar-thumb {
        background: #E3F1FB;
        border-radius: 9999px;
    }
    .sidebar-nav::-webkit-scrollbar-thumb:hover {
        background: #0EA5E9;
    }

    /* ── Firefox Scrollbar ───────────────────────────── */
    .sidebar-nav {
        scrollbar-width: thin;
        scrollbar-color: #E3F1FB transparent;
    }
</style>
@endpush

@push('scripts')
<script>
    // ── Toggle Sidebar (Mobile) ────────────────────────
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggle  = document.getElementById('sidebar-toggle');
        const isOpen  = !sidebar.classList.contains('-translate-x-full');

        if (isOpen) {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            if (toggle) toggle.classList.remove('hidden');
        } else {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            if (toggle) toggle.classList.add('hidden');
        }
    }

    // ── Toggle Section Collapse ────────────────────────
    function toggleSection(id) {
        const section = document.getElementById('section-' + id);
        const chevron = document.getElementById('chevron-' + id);

        if (section && chevron) {
            section.classList.toggle('open');
            chevron.classList.toggle('rotate-180');
        }
    }

    // ── Auto-close sidebar on resize to desktop ────────
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const toggle  = document.getElementById('sidebar-toggle');

            sidebar.classList.remove('-translate-x-full');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            if (toggle) toggle.classList.remove('hidden');
        }
    });
</script>
@endpush