@extends('layouts.guest')

@section('title', 'Beranda')

@section('content')

    {{-- ==========================================================
         HERO
    =========================================================== --}}
    <section class="relative overflow-hidden">
        {{-- ambient glow --}}
        <div class="pointer-events-none absolute -top-32 -left-24 h-96 w-96 rounded-full bg-[#0EA5E9]/20 blur-[100px]"></div>
        <div class="pointer-events-none absolute top-10 right-0 h-80 w-80 rounded-full bg-[#0284C7]/10 blur-[100px]"></div>

        <div class="relative max-w-6xl mx-auto px-6 pt-16 pb-20">
            <div class="grid lg:grid-cols-2 gap-12 items-center">

                {{-- Left: copy --}}
                <div class="animate-[fadeUp_.6s_ease_forwards] opacity-0">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white border border-[#E3F1FB] px-4 py-1.5 text-xs font-medium text-[#0284C7] shadow-[0_8px_24px_-8px_rgba(14,165,233,0.25)]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                        </svg>
                        Perpustakaan Digital Kampus
                    </span>

                    <h1 class="mt-6 font-[Fraunces] tracking-tight text-4xl md:text-5xl leading-[1.1] text-[#0C2D3F]">
                        Temukan, pinjam, dan
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#0EA5E9] to-[#0369A1]">jelajahi koleksi buku</span>
                        favoritmu
                    </h1>

                    <p class="mt-5 text-[#5B7587] text-base leading-relaxed max-w-md">
                        BookVerse membantu kamu menemukan buku, mengelola peminjaman, dan menjaga jadwal pengembalian tetap rapi — semua dalam satu tempat.
                    </p>

                    {{-- search --}}
                    <form class="mt-8 flex items-center gap-3 bg-white rounded-full border border-[#E3F1FB] pl-5 pr-1.5 py-1.5 shadow-[0_20px_45px_-20px_rgba(14,165,233,0.35)] max-w-md focus-within:border-[#0EA5E9] transition-colors">
                        <svg class="w-4.5 h-4.5 text-[#5B7587] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5A6.5 6.5 0 114 10.5a6.5 6.5 0 0113 0z"/>
                        </svg>
                        <input
                            type="text"
                            placeholder="Cari judul, penulis, atau ISBN..."
                            class="w-full bg-transparent border-0 focus:ring-0 text-sm text-[#0C2D3F] placeholder:text-[#5B7587]/70 py-2"
                        >
                        <button type="submit" class="shrink-0 rounded-full bg-gradient-to-r from-[#0EA5E9] to-[#0284C7] text-white text-sm font-medium px-5 py-2.5 shadow-[0_10px_25px_-8px_rgba(2,132,199,0.6)] hover:-translate-y-0.5 hover:shadow-[0_16px_30px_-8px_rgba(2,132,199,0.7)] transition-all duration-200">
                            Cari
                        </button>
                    </form>

                    <div class="mt-6 flex items-center gap-2 text-xs text-[#5B7587]">
                        <span>Populer:</span>
                        <a href="#" class="rounded-full bg-white border border-[#E3F1FB] px-3 py-1 hover:border-[#0EA5E9] hover:text-[#0284C7] transition-colors">Fiksi</a>
                        <a href="#" class="rounded-full bg-white border border-[#E3F1FB] px-3 py-1 hover:border-[#0EA5E9] hover:text-[#0284C7] transition-colors">Sains</a>
                        <a href="#" class="rounded-full bg-white border border-[#E3F1FB] px-3 py-1 hover:border-[#0EA5E9] hover:text-[#0284C7] transition-colors">Sejarah</a>
                    </div>
                </div>

                {{-- Right: illustration card stack --}}
                <div class="relative hidden lg:block animate-[fadeUp_.7s_.1s_ease_forwards] opacity-0">
                    <div class="relative mx-auto w-full max-w-sm aspect-[4/5] rounded-[28px] bg-white border border-[#E3F1FB] shadow-[0_40px_80px_-30px_rgba(14,165,233,0.4)] p-6 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-[#5B7587]">Sedang Dipinjam</span>
                            <span class="rounded-full bg-[#10B981]/10 text-[#10B981] text-[11px] font-medium px-3 py-1">Aktif</span>
                        </div>

                        <div class="space-y-4">
                            <div class="h-28 w-20 rounded-xl bg-gradient-to-br from-[#0EA5E9] to-[#0369A1] shadow-lg"></div>
                            <div>
                                <p class="font-[Fraunces] text-lg text-[#0C2D3F] leading-snug">Filosofi Ilmu &amp;<br>Metode Berpikir</p>
                                <p class="text-xs text-[#5B7587] mt-1">Sujarwo Hadi &middot; 312 hlm</p>
                            </div>
                        </div>

                        <div class="border-t border-[#E3F1FB] pt-4 flex items-center justify-between text-xs text-[#5B7587]">
                            <span>Jatuh tempo</span>
                            <span class="font-medium text-[#0C2D3F]">12 Jul 2026</span>
                        </div>
                    </div>

                    {{-- floating badge card --}}
                    <div class="absolute -bottom-6 -left-6 w-48 rounded-2xl bg-white border border-[#E3F1FB] shadow-[0_25px_50px_-20px_rgba(14,165,233,0.35)] p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#0EA5E9]/10 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-[#0EA5E9]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-[#0C2D3F]">12.480+</p>
                                <p class="text-[11px] text-[#5B7587]">Judul buku</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ==========================================================
         STATISTIK
    =========================================================== --}}
    <section class="max-w-6xl mx-auto px-6 py-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
                $stats = [
                    ['label' => 'Total Koleksi', 'value' => '12.480', 'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25'],
                    ['label' => 'Anggota Aktif', 'value' => '3.216', 'icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z'],
                    ['label' => 'Sedang Dipinjam', 'value' => '842', 'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25'],
                    ['label' => 'Kategori', 'value' => '36', 'icon' => 'M9 3.75H6.912a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661V18a2.25 2.25 0 002.25 2.25h15a2.25 2.25 0 002.25-2.25v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859M12 3v8.25m0 0l-3-3m3 3l3-3'],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div class="rounded-[24px] bg-white border border-[#E3F1FB] shadow-[0_20px_40px_-28px_rgba(14,165,233,0.35)] p-5 hover:-translate-y-1 transition-transform duration-200">
                    <div class="w-10 h-10 rounded-xl bg-[#0EA5E9]/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#0EA5E9]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}"/>
                        </svg>
                    </div>
                    <p class="mt-4 font-[Fraunces] text-2xl text-[#0C2D3F]">{{ $stat['value'] }}</p>
                    <p class="text-xs text-[#5B7587] mt-1">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ==========================================================
         KATEGORI POPULER
    =========================================================== --}}
    <section class="max-w-6xl mx-auto px-6 py-14">
        <div class="flex items-end justify-between mb-6">
            <div>
                <p class="text-xs font-medium text-[#0284C7] mb-2">Jelajahi</p>
                <h2 class="font-[Fraunces] text-2xl text-[#0C2D3F]">Kategori Populer</h2>
            </div>
            <a href="#" class="text-sm text-[#0284C7] font-medium hover:text-[#0369A1] transition-colors">Lihat semua &rarr;</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @php
                $categories = [
                    ['name' => 'Fiksi', 'count' => '2.140'],
                    ['name' => 'Sains', 'count' => '1.532'],
                    ['name' => 'Sejarah', 'count' => '984'],
                    ['name' => 'Teknologi', 'count' => '1.870'],
                    ['name' => 'Filsafat', 'count' => '612'],
                    ['name' => 'Ekonomi', 'count' => '745'],
                ];
            @endphp

            @foreach ($categories as $cat)
                <a href="#" class="group rounded-2xl bg-white border border-[#E3F1FB] p-5 text-center hover:border-[#0EA5E9] hover:-translate-y-1 transition-all duration-200 shadow-[0_16px_32px_-26px_rgba(14,165,233,0.4)]">
                    <p class="text-sm font-medium text-[#0C2D3F] group-hover:text-[#0284C7]">{{ $cat['name'] }}</p>
                    <p class="text-[11px] text-[#5B7587] mt-1">{{ $cat['count'] }} judul</p>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ==========================================================
         BUKU TERBARU
    =========================================================== --}}
    <section class="max-w-6xl mx-auto px-6 py-6 pb-20">
        <div class="flex items-end justify-between mb-6">
            <div>
                <p class="text-xs font-medium text-[#0284C7] mb-2">Baru Ditambahkan</p>
                <h2 class="font-[Fraunces] text-2xl text-[#0C2D3F]">Koleksi Terbaru</h2>
            </div>
            <a href="#" class="text-sm text-[#0284C7] font-medium hover:text-[#0369A1] transition-colors">Lihat katalog &rarr;</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @php
                $books = [
                    ['title' => 'Bumi Manusia', 'author' => 'Pramoedya A.T.', 'badge' => 'Fiksi', 'from' => '#0EA5E9', 'to' => '#0369A1'],
                    ['title' => 'Sapiens', 'author' => 'Yuval N. Harari', 'badge' => 'Sains', 'from' => '#38BDF8', 'to' => '#0284C7'],
                    ['title' => 'Laut Bercerita', 'author' => 'Leila S. Chudori', 'badge' => 'Fiksi', 'from' => '#0284C7', 'to' => '#0C2D3F'],
                    ['title' => 'Atomic Habits', 'author' => 'James Clear', 'badge' => 'Pengembangan Diri', 'from' => '#0EA5E9', 'to' => '#38BDF8'],
                ];
            @endphp

            @foreach ($books as $book)
                <div class="group rounded-[24px] bg-white border border-[#E3F1FB] p-4 shadow-[0_20px_40px_-28px_rgba(14,165,233,0.35)] hover:-translate-y-1.5 hover:shadow-[0_30px_50px_-24px_rgba(14,165,233,0.45)] transition-all duration-300">
                    <div class="rounded-2xl h-40 w-full mb-4 shadow-inner" style="background: linear-gradient(135deg, {{ $book['from'] }}, {{ $book['to'] }})"></div>
                    <span class="inline-block rounded-full bg-[#0EA5E9]/10 text-[#0284C7] text-[11px] font-medium px-3 py-1 mb-2">{{ $book['badge'] }}</span>
                    <p class="font-[Fraunces] text-base text-[#0C2D3F] leading-snug">{{ $book['title'] }}</p>
                    <p class="text-xs text-[#5B7587] mt-1">{{ $book['author'] }}</p>

                    <button class="mt-4 w-full rounded-full bg-[#F3F9FE] text-[#0284C7] text-xs font-medium py-2.5 group-hover:bg-gradient-to-r group-hover:from-[#0EA5E9] group-hover:to-[#0284C7] group-hover:text-white transition-all duration-200">
                        Lihat Detail
                    </button>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ==========================================================
         CTA
    =========================================================== --}}
    <section class="max-w-6xl mx-auto px-6 pb-20">
        <div class="relative overflow-hidden rounded-[28px] bg-gradient-to-r from-[#0EA5E9] to-[#0369A1] px-8 py-14 md:px-16 text-center shadow-[0_40px_80px_-30px_rgba(3,105,161,0.5)]">
            <div class="pointer-events-none absolute inset-0 opacity-[0.08]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 22px 22px;"></div>
            <h2 class="relative font-[Fraunces] text-2xl md:text-3xl text-white leading-tight">
                Belum punya akun anggota?
            </h2>
            <p class="relative text-white/80 text-sm mt-3 max-w-md mx-auto">
                Daftar sekarang dan mulai pinjam buku favoritmu dari koleksi BookVerse.
            </p>
            <a href="#" class="relative inline-block mt-7 rounded-full bg-white text-[#0284C7] text-sm font-medium px-7 py-3 shadow-lg hover:-translate-y-0.5 transition-transform duration-200">
                Daftar Sekarang
            </a>
        </div>
    </section>

@endsection

@push('styles')
<style>
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush