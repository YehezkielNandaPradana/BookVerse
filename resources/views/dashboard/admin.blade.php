@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')

@php
    $chartData = [
        ['month' => 'Jan', 'value' => 45],
        ['month' => 'Feb', 'value' => 62],
        ['month' => 'Mar', 'value' => 38],
        ['month' => 'Apr', 'value' => 75],
        ['month' => 'Mei', 'value' => 55],
        ['month' => 'Jun', 'value' => 88],
        ['month' => 'Jul', 'value' => 72],
    ];

    $transactions = [
        ['initials' => 'AR', 'name' => 'Ahmad Rizki', 'book' => 'Laskar Pelangi', 'date' => '14 Jul 2025', 'status' => 'Dipinjam', 'stamp' => 'text-[#0B4F71] border-[#0B4F71]'],
        ['initials' => 'SN', 'name' => 'Siti Nurhaliza', 'book' => 'Bumi Manusia', 'date' => '14 Jul 2025', 'status' => 'Dikembalikan', 'stamp' => 'text-[#4C7A61] border-[#4C7A61]'],
        ['initials' => 'BW', 'name' => 'Budi Wicaksono', 'book' => 'Filosofi Teras', 'date' => '13 Jul 2025', 'status' => 'Terlambat', 'stamp' => 'text-[#B54B3A] border-[#B54B3A]'],
        ['initials' => 'DP', 'name' => 'Dewi Pertiwi', 'book' => 'Sapiens', 'date' => '13 Jul 2025', 'status' => 'Dipinjam', 'stamp' => 'text-[#0B4F71] border-[#0B4F71]'],
        ['initials' => 'FH', 'name' => 'Fajar Hidayat', 'book' => 'Atomic Habits', 'date' => '12 Jul 2025', 'status' => 'Dikembalikan', 'stamp' => 'text-[#4C7A61] border-[#4C7A61]'],
    ];

    $popularBooks = [
        ['title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'borrows' => 128, 'cover' => 'https://picsum.photos/seed/bookverse-lp/96/128', 'spine' => '#0B4F71'],
        ['title' => 'Bumi Manusia', 'author' => 'Pramoedya A.T.', 'borrows' => 115, 'cover' => 'https://picsum.photos/seed/bookverse-bm/96/128', 'spine' => '#4C7A61'],
        ['title' => 'Filosofi Teras', 'author' => 'Henry Manampiring', 'borrows' => 102, 'cover' => 'https://picsum.photos/seed/bookverse-ft/96/128', 'spine' => '#C08A2E'],
        ['title' => 'Atomic Habits', 'author' => 'James Clear', 'borrows' => 97, 'cover' => 'https://picsum.photos/seed/bookverse-ah/96/128', 'spine' => '#B54B3A'],
    ];

    // rotation rhythm for the ink-stamp badges, so they read as hand-stamped rather than printed
    $stampTilts = [-3, 2, -2, 3, -4];
@endphp

<div class="relative z-10 space-y-8 pb-12 animate-[fadeSlideUp_0.6s_ease-out_both]">

    {{-- ==================== GREETING & ACTIONS ==================== --}}
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 border border-dashed border-[#0B4F71]/35 rounded-lg px-3 py-1 mb-3">
                <svg class="w-3.5 h-3.5 text-[#0B4F71]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                <span class="font-mono text-[11px] font-semibold tracking-[0.12em] text-[#0B4F71] uppercase">Senin · 14 Jul 2025</span>
            </div>
            <h1 class="font-['Fraunces'] text-3xl md:text-4xl font-semibold text-[#0C2D3F] tracking-tight">
                Selamat datang, Admin
            </h1>
            <p class="mt-2 text-[#5B7587] font-['Inter'] text-[15px]">Buku besar sirkulasi hari ini — semua pinjam, kembali, dan telat tercatat di sini.</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            {{-- Notification Bell --}}
            <button class="relative w-11 h-11 rounded-full bg-[#FEFCF8] border border-[#E7EFF5] shadow-[0_4px_20px_rgba(14,165,233,0.08)] flex items-center justify-center hover:shadow-[0_8px_28px_rgba(14,165,233,0.15)] hover:-translate-y-0.5 transition-all duration-300">
                <svg class="w-5 h-5 text-[#5B7587]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                <span class="absolute -top-1 -right-1 w-5 h-5 bg-[#B54B3A] text-white text-[10px] font-bold rounded-full flex items-center justify-center shadow-sm font-mono">3</span>
            </button>
            {{-- Download Report Button --}}
            <button class="btn-shine relative overflow-hidden px-5 py-2.5 bg-gradient-to-r from-[#0B4F71] to-[#0EA5E9] text-white font-['Inter'] font-medium text-sm rounded-full shadow-[0_4px_20px_rgba(14,165,233,0.3)] hover:shadow-[0_8px_32px_rgba(14,165,233,0.4)] hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Unduh Laporan
            </button>
        </div>
    </div>

    {{-- ==================== STAT CARDS — "INDEX CARDS" ==================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        {{-- Total Buku --}}
        <div class="index-card bg-[#FEFCF8] rounded-2xl border border-[#E7EFF5] overflow-hidden shadow-[0_4px_24px_rgba(14,165,233,0.06)] hover:shadow-[0_8px_36px_rgba(14,165,233,0.12)] hover:-translate-y-1 transition-all duration-300 animate-[fadeSlideUp_0.5s_ease-out_0.1s_both]">
            <div class="h-[5px] w-full bg-[#0B4F71]"></div>
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div class="w-11 h-11 rounded-xl bg-[#0B4F71]/8 flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#0B4F71]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <span class="font-mono text-[11px] font-semibold text-[#4C7A61]">▲ 12.5%</span>
                </div>
                <div class="mt-5">
                    <p class="font-mono text-[26px] font-bold text-[#0C2D3F] leading-tight tracking-tight">12.486</p>
                    <p class="mt-1 text-sm text-[#5B7587] font-['Inter']">Total Buku</p>
                </div>
            </div>
        </div>

        {{-- Total Anggota --}}
        <div class="index-card bg-[#FEFCF8] rounded-2xl border border-[#E7EFF5] overflow-hidden shadow-[0_4px_24px_rgba(14,165,233,0.06)] hover:shadow-[0_8px_36px_rgba(14,165,233,0.12)] hover:-translate-y-1 transition-all duration-300 animate-[fadeSlideUp_0.5s_ease-out_0.15s_both]">
            <div class="h-[5px] w-full bg-[#4C7A61]"></div>
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div class="w-11 h-11 rounded-xl bg-[#4C7A61]/8 flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#4C7A61]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                    <span class="font-mono text-[11px] font-semibold text-[#4C7A61]">▲ 8.2%</span>
                </div>
                <div class="mt-5">
                    <p class="font-mono text-[26px] font-bold text-[#0C2D3F] leading-tight tracking-tight">3.842</p>
                    <p class="mt-1 text-sm text-[#5B7587] font-['Inter']">Total Anggota</p>
                </div>
            </div>
        </div>

        {{-- Sedang Dipinjam --}}
        <div class="index-card bg-[#FEFCF8] rounded-2xl border border-[#E7EFF5] overflow-hidden shadow-[0_4px_24px_rgba(14,165,233,0.06)] hover:shadow-[0_8px_36px_rgba(14,165,233,0.12)] hover:-translate-y-1 transition-all duration-300 animate-[fadeSlideUp_0.5s_ease-out_0.2s_both]">
            <div class="h-[5px] w-full bg-[#C08A2E]"></div>
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div class="w-11 h-11 rounded-xl bg-[#C08A2E]/8 flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#C08A2E]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182" />
                        </svg>
                    </div>
                    <span class="font-mono text-[11px] font-semibold text-[#4C7A61]">▲ 3.1%</span>
                </div>
                <div class="mt-5">
                    <p class="font-mono text-[26px] font-bold text-[#0C2D3F] leading-tight tracking-tight">847</p>
                    <p class="mt-1 text-sm text-[#5B7587] font-['Inter']">Sedang Dipinjam</p>
                </div>
            </div>
        </div>

        {{-- Terlambat Kembali --}}
        <div class="index-card bg-[#FEFCF8] rounded-2xl border border-[#E7EFF5] overflow-hidden shadow-[0_4px_24px_rgba(14,165,233,0.06)] hover:shadow-[0_8px_36px_rgba(14,165,233,0.12)] hover:-translate-y-1 transition-all duration-300 animate-[fadeSlideUp_0.5s_ease-out_0.25s_both]">
            <div class="h-[5px] w-full bg-[#B54B3A]"></div>
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div class="w-11 h-11 rounded-xl bg-[#B54B3A]/8 flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#B54B3A]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <span class="font-mono text-[11px] font-semibold text-[#4C7A61]">▼ 15.3%</span>
                </div>
                <div class="mt-5">
                    <p class="font-mono text-[26px] font-bold text-[#0C2D3F] leading-tight tracking-tight">23</p>
                    <p class="mt-1 text-sm text-[#5B7587] font-['Inter']">Terlambat Kembali</p>
                </div>
            </div>
        </div>

    </div>

    {{-- ==================== MAIN CONTENT GRID ==================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ==================== LEFT COLUMN ==================== --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Trend Peminjaman Chart --}}
            <div class="bg-[#FEFCF8] rounded-3xl border border-[#E7EFF5] p-6 md:p-8 shadow-[0_4px_24px_rgba(14,165,233,0.06)] animate-[fadeSlideUp_0.5s_ease-out_0.3s_both]">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                    <div>
                        <h2 class="font-['Fraunces'] text-xl font-semibold text-[#0C2D3F] tracking-tight">Tren Peminjaman</h2>
                        <p class="mt-1 text-sm text-[#5B7587] font-['Inter']">Data 7 bulan terakhir</p>
                    </div>
                    <div class="flex items-center gap-1 bg-[#F3F9FE] rounded-full p-1 self-start">
                        <button class="chart-tab active px-4 py-1.5 text-xs font-medium rounded-full transition-all duration-300">Mingguan</button>
                        <button class="chart-tab px-4 py-1.5 text-xs font-medium text-[#5B7587] rounded-full hover:text-[#0C2D3F] transition-all duration-300">Bulanan</button>
                    </div>
                </div>

                {{-- Bar Chart on ledger lines --}}
                <div class="ledger-lines flex items-end justify-between gap-2 sm:gap-4 h-52 px-2 rounded-xl">
                    @foreach($chartData as $index => $data)
                        <div class="flex-1 flex flex-col items-center gap-2">
                            <span class="font-mono text-[11px] font-bold text-[#0C2D3F] opacity-0 animate-[fadeIn_0.4s_ease-out_{{ 0.6 + ($index * 0.08) }}s_both]">{{ $data['value'] }}</span>
                            <div class="w-full max-w-[44px] rounded-t-md bg-gradient-to-t from-[#0B4F71] to-[#38BDF8] bar-grow hover:from-[#0EA5E9] hover:to-[#0B4F71] cursor-pointer transition-colors duration-300 shadow-[0_2px_12px_rgba(14,165,233,0.2)]"
                                 style="height: {{ $data['value'] }}%; animation-delay: {{ 0.5 + ($index * 0.08) }}s">
                            </div>
                            <span class="font-mono text-[11px] text-[#5B7587] uppercase tracking-wide">{{ $data['month'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Transaksi Terbaru — Ledger Card --}}
            <div class="bg-[#FEFCF8] rounded-3xl border border-[#E7EFF5] shadow-[0_4px_24px_rgba(14,165,233,0.06)] overflow-hidden animate-[fadeSlideUp_0.5s_ease-out_0.4s_both]">
                <div class="flex">
                    {{-- Punch-hole ledger strip --}}
                    <div class="punch-strip w-8 shrink-0 hidden sm:block" aria-hidden="true"></div>

                    <div class="flex-1 min-w-0">
                        <div class="p-6 md:p-8 pb-0">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h2 class="font-['Fraunces'] text-xl font-semibold text-[#0C2D3F] tracking-tight">Transaksi Terbaru</h2>
                                    <p class="mt-1 text-sm text-[#5B7587] font-['Inter']">5 transaksi terakhir</p>
                                </div>
                                <a href="#" class="text-sm font-medium text-[#0EA5E9] hover:text-[#0284C7] transition-colors duration-200">Lihat Semua</a>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[560px]">
                                <thead>
                                    <tr class="border-b border-[#E7EFF5]">
                                        <th class="text-left text-[11px] font-semibold text-[#5B7587] uppercase tracking-wider px-6 md:px-8 py-4 font-mono">Anggota</th>
                                        <th class="text-left text-[11px] font-semibold text-[#5B7587] uppercase tracking-wider px-6 py-4 font-mono">Buku</th>
                                        <th class="text-left text-[11px] font-semibold text-[#5B7587] uppercase tracking-wider px-6 py-4 font-mono">Tanggal</th>
                                        <th class="text-left text-[11px] font-semibold text-[#5B7587] uppercase tracking-wider px-6 md:pr-8 py-4 font-mono">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $index => $tx)
                                        <tr class="border-b border-[#E7EFF5]/50 last:border-b-0 hover:bg-[#F3F9FE]/60 transition-colors duration-200">
                                            <td class="px-6 md:px-8 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-9 h-9 rounded-full border border-dashed border-[#0B4F71]/30 bg-[#0B4F71]/5 flex items-center justify-center shrink-0">
                                                        <span class="font-mono text-[11px] font-bold text-[#0B4F71]">{{ $tx['initials'] }}</span>
                                                    </div>
                                                    <span class="text-sm font-medium text-[#0C2D3F] font-['Inter'] whitespace-nowrap">{{ $tx['name'] }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-[#5B7587] font-['Inter']">{{ $tx['book'] }}</td>
                                            <td class="px-6 py-4 font-mono text-xs text-[#5B7587] whitespace-nowrap">{{ $tx['date'] }}</td>
                                            <td class="px-6 md:pr-8 py-4">
                                                <span class="stamp-badge {{ $tx['stamp'] }}" style="transform: rotate({{ $stampTilts[$index % count($stampTilts)] }}deg)">
                                                    {{ $tx['status'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ==================== RIGHT COLUMN ==================== --}}
        <div class="space-y-6">

            {{-- Buku Populer --}}
            <div class="bg-[#FEFCF8] rounded-3xl border border-[#E7EFF5] p-6 shadow-[0_4px_24px_rgba(14,165,233,0.06)] animate-[fadeSlideUp_0.5s_ease-out_0.5s_both]">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="font-['Fraunces'] text-xl font-semibold text-[#0C2D3F] tracking-tight">Buku Populer</h2>
                    <a href="#" class="text-sm font-medium text-[#0EA5E9] hover:text-[#0284C7] transition-colors duration-200">Lihat Semua</a>
                </div>
                <div class="space-y-1">
                    @foreach($popularBooks as $index => $book)
                        <div class="flex items-center gap-3.5 p-3 -mx-3 rounded-2xl hover:bg-[#F3F9FE]/80 transition-all duration-200 cursor-pointer group">
                            <span class="font-mono text-xs font-bold text-[#5B7587] w-4 shrink-0">{{ $index + 1 }}</span>
                            <div class="relative shrink-0">
                                <img src="{{ $book['cover'] }}" alt="{{ $book['title'] }}" class="w-11 h-15 rounded-lg object-cover shadow-[0_2px_8px_rgba(0,0,0,0.08)]">
                                <span class="absolute -left-1.5 top-0 bottom-0 w-1 rounded-full" style="background-color: {{ $book['spine'] }}"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-[#0C2D3F] font-['Inter'] truncate group-hover:text-[#0EA5E9] transition-colors duration-200">{{ $book['title'] }}</p>
                                <p class="text-xs text-[#5B7587] font-['Inter'] mt-0.5 truncate">{{ $book['author'] }}</p>
                            </div>
                            <span class="font-mono text-xs font-semibold text-[#5B7587] whitespace-nowrap">{{ $book['borrows'] }}×</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Aksi Cepat --}}
            <div class="bg-[#FEFCF8] rounded-3xl border border-[#E7EFF5] p-6 shadow-[0_4px_24px_rgba(14,165,233,0.06)] animate-[fadeSlideUp_0.5s_ease-out_0.6s_both]">
                <h2 class="font-['Fraunces'] text-xl font-semibold text-[#0C2D3F] tracking-tight mb-6">Aksi Cepat</h2>
                <div class="space-y-3">

                    {{-- Tambah Buku Baru --}}
                    <a href="#" class="flex items-center gap-3.5 p-3.5 -mx-3.5 rounded-2xl border border-[#E7EFF5] hover:border-[#0B4F71]/30 hover:bg-[#F3F9FE]/60 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(14,165,233,0.08)] transition-all duration-300 group">
                        <div class="w-10 h-10 rounded-xl bg-[#0B4F71]/8 flex items-center justify-center shrink-0 group-hover:bg-[#0B4F71]/15 transition-all duration-300">
                            <svg class="w-5 h-5 text-[#0B4F71]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-[#0C2D3F] font-['Inter']">Tambah Buku Baru</span>
                        <svg class="w-4 h-4 text-[#5B7587] ml-auto opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>

                    {{-- Kelola Anggota --}}
                    <a href="#" class="flex items-center gap-3.5 p-3.5 -mx-3.5 rounded-2xl border border-[#E7EFF5] hover:border-[#4C7A61]/30 hover:bg-[#F3F9FE]/60 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(14,165,233,0.08)] transition-all duration-300 group">
                        <div class="w-10 h-10 rounded-xl bg-[#4C7A61]/8 flex items-center justify-center shrink-0 group-hover:bg-[#4C7A61]/15 transition-all duration-300">
                            <svg class="w-5 h-5 text-[#4C7A61]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-[#0C2D3F] font-['Inter']">Kelola Anggota</span>
                        <svg class="w-4 h-4 text-[#5B7587] ml-auto opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>

                    {{-- Proses Pengembalian --}}
                    <a href="#" class="flex items-center gap-3.5 p-3.5 -mx-3.5 rounded-2xl border border-[#E7EFF5] hover:border-[#C08A2E]/30 hover:bg-[#F3F9FE]/60 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(14,165,233,0.08)] transition-all duration-300 group">
                        <div class="w-10 h-10 rounded-xl bg-[#C08A2E]/8 flex items-center justify-center shrink-0 group-hover:bg-[#C08A2E]/15 transition-all duration-300">
                            <svg class="w-5 h-5 text-[#C08A2E]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-[#0C2D3F] font-['Inter']">Proses Pengembalian</span>
                        <svg class="w-4 h-4 text-[#5B7587] ml-auto opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>

                    {{-- Laporan Bulanan --}}
                    <a href="#" class="flex items-center gap-3.5 p-3.5 -mx-3.5 rounded-2xl border border-[#E7EFF5] hover:border-[#0EA5E9]/30 hover:bg-[#F3F9FE]/60 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(14,165,233,0.08)] transition-all duration-300 group">
                        <div class="w-10 h-10 rounded-xl bg-[#0EA5E9]/8 flex items-center justify-center shrink-0 group-hover:bg-[#0EA5E9]/15 transition-all duration-300">
                            <svg class="w-5 h-5 text-[#0EA5E9]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-[#0C2D3F] font-['Inter']">Laporan Bulanan</span>
                        <svg class="w-4 h-4 text-[#5B7587] ml-auto opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>

                </div>
            </div>

            {{-- Info Card — Pinned Notice --}}
            <div class="bg-gradient-to-br from-[#0B4F71] to-[#0EA5E9] rounded-3xl p-6 shadow-[0_8px_32px_rgba(14,165,233,0.25)] animate-[fadeSlideUp_0.5s_ease-out_0.7s_both] relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-8 translate-x-8"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-8 -translate-x-8"></div>
                <div class="relative z-10">
                    <span class="font-mono text-[10px] font-bold tracking-[0.15em] text-white/70 uppercase">Pengumuman</span>
                    <h3 class="mt-2 font-['Fraunces'] text-lg font-semibold text-white tracking-tight">Jadwal Libur</h3>
                    <div class="mt-3 inline-flex items-center gap-2 border border-dashed border-white/40 rounded-lg px-3 py-1.5">
                        <svg class="w-3.5 h-3.5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-mono text-xs font-semibold text-white">17 AGUSTUS 2025</span>
                    </div>
                    <p class="mt-3 text-sm text-white/80 font-['Inter'] leading-relaxed">Perpustakaan tutup dalam rangka HUT RI.</p>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<style>
    @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&display=swap');

    /* ========== PAGE BACKGROUND ========== */
    @if(!app()->runningInConsole())
    main, .main-content, [class*="content-wrapper"] {
        background-color: #F3F9FE !important;
        background-image:
            radial-gradient(ellipse at 20% 0%, rgba(14,165,233,0.07) 0%, transparent 50%),
            radial-gradient(ellipse at 80% 100%, rgba(14,165,233,0.04) 0%, transparent 50%),
            repeating-linear-gradient(to bottom, transparent, transparent 31px, rgba(11,79,113,0.028) 31px, rgba(11,79,113,0.028) 32px) !important;
        background-size: 100% 100%, 100% 100%, 100% 32px !important;
    }
    @endif

    /* ========== ANIMATIONS ========== */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes growBar {
        from { transform: scaleY(0); }
        to { transform: scaleY(1); }
    }

    /* ========== BAR CHART GROW ========== */
    .bar-grow {
        transform-origin: bottom;
        transform: scaleY(0);
        animation: growBar 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    /* ========== LEDGER LINES BEHIND CHART ========== */
    .ledger-lines {
        background-image: repeating-linear-gradient(to bottom, transparent, transparent 31px, rgba(11,79,113,0.06) 31px, rgba(11,79,113,0.06) 32px);
    }

    /* ========== PUNCH-HOLE LEDGER STRIP ========== */
    .punch-strip {
        background-color: #F3F9FE;
        background-image: radial-gradient(circle at 16px 20px, #FEFCF8 7px, transparent 7.3px);
        background-repeat: repeat-y;
        background-size: 32px 40px;
        border-right: 1.5px dashed #E3F1FB;
    }

    /* ========== INK STAMP BADGE ========== */
    .stamp-badge {
        display: inline-block;
        font-family: 'JetBrains Mono', monospace;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        padding: 4px 11px;
        border-radius: 5px;
        border: 1.5px dashed currentColor;
        background: transparent;
    }

    /* ========== INDEX CARD ========== */
    .index-card { position: relative; }

    /* ========== BUTTON SHINE ========== */
    .btn-shine { position: relative; overflow: hidden; }
    .btn-shine::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 60%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
        transition: left 0.6s ease;
    }
    .btn-shine:hover::after { left: 120%; }

    /* ========== CHART TAB SWITCH ========== */
    .chart-tab.active {
        color: white;
        background: linear-gradient(to right, #0B4F71, #0EA5E9);
    }

    /* ========== SCROLLBAR ========== */
    .overflow-x-auto::-webkit-scrollbar { height: 4px; }
    .overflow-x-auto::-webkit-scrollbar-track { background: transparent; }
    .overflow-x-auto::-webkit-scrollbar-thumb { background: #E3F1FB; border-radius: 100px; }
    .overflow-x-auto::-webkit-scrollbar-thumb:hover { background: #0EA5E9; }

    /* ========== FONT FALLBACK ========== */
    .font-\[\'Fraunces\'\] { font-family: 'Fraunces', Georgia, serif; }
    .font-\[\'Inter\'\] { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
    .font-mono { font-family: 'JetBrains Mono', ui-monospace, monospace; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('.chart-tab');
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(function (t) { t.classList.remove('active'); });
                this.classList.add('active');
            });
        });
    });
</script>
@endpush