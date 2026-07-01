@extends('layouts.guest')

@section('title', 'Beranda')

@push('styles')
<style>
    .bv-root{width:100%}
    .bv-hero-grid{display:grid;grid-template-columns:1fr;gap:3rem;align-items:center}
    .bv-stats-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1rem}
    .bv-cats-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1rem}
    .bv-books-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1.25rem}
    .bv-row{display:flex;align-items:flex-end;justify-content:space-between}
    .bv-search{display:flex;align-items:center;gap:0.75rem}
    .bv-tags{display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap}
    .bv-card-row{display:flex;align-items:center;justify-content:space-between}
    .bv-card-foot{border-top:1px solid #E3F1FB;padding-top:1rem;display:flex;align-items:center;justify-content:space-between}
    .bv-badge-row{display:flex;align-items:center;gap:0.75rem}
    .bv-icon-box{width:2.5rem;height:2.5rem;border-radius:0.75rem;background:rgba(14,165,233,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .bv-hero-illust{display:none}
    .bv-nav{position:sticky;top:0;z-index:50;background:rgba(255,255,255,0.85);-webkit-backdrop-filter:blur(12px);backdrop-filter:blur(12px);border-bottom:1px solid #E3F1FB}
    .bv-nav-inner{max-width:72rem;margin:0 auto;padding:0.875rem 1.5rem;display:flex;align-items:center;justify-content:space-between}
    .bv-nav-links{display:flex;align-items:center;gap:1rem}
    @media(min-width:768px){
        .bv-stats-grid{grid-template-columns:repeat(4,1fr)}
        .bv-cats-grid{grid-template-columns:repeat(3,1fr)}
        .bv-books-grid{grid-template-columns:repeat(4,1fr)}
    }
    @media(min-width:1024px){
        .bv-hero-grid{grid-template-columns:1fr 1fr}
        .bv-cats-grid{grid-template-columns:repeat(6,1fr)}
        .bv-hero-illust{display:block}
        .bv-nav-links{gap:1.25rem}
    }
</style>
@endpush

@section('content')
<div class="bv-root">

    {{-- ==========================================================
         NAVIGASI
    =========================================================== --}}
    <nav class="bv-nav">
        <div class="bv-nav-inner">
            <a href="{{ route('beranda') }}" style="font-family:'Fraunces',serif; font-size:1.25rem; font-weight:600; color:#0C2D3F; text-decoration:none; transition:opacity 0.2s;"
               onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                Book<span style="color:#0EA5E9;">Verse</span>
            </a>

            <div class="bv-nav-links">
                <a href="{{ route('login') }}" style="font-size:0.875rem; color:#5B7587; text-decoration:none; font-weight:500; font-family:'Inter',sans-serif; transition:color 0.2s; padding:0.5rem 0;"
                   onmouseover="this.style.color='#0EA5E9'" onmouseout="this.style.color='#5B7587'">
                    Masuk
                </a>
                <a href="{{ route('register') }}" style="font-size:0.875rem; color:#fff; background:linear-gradient(135deg,#0EA5E9,#0284C7); border-radius:9999px; padding:0.5rem 1.25rem; text-decoration:none; font-weight:500; font-family:'Inter',sans-serif; box-shadow:0 8px 20px -6px rgba(14,165,233,0.4); transition:all 0.2s;"
                   onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 12px 24px -6px rgba(14,165,233,0.5)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px -6px rgba(14,165,233,0.4)'">
                    Daftar
                </a>
            </div>
        </div>
    </nav>

    {{-- ==========================================================
         HERO
    =========================================================== --}}
    <section style="position:relative; overflow:hidden;">
        <div style="pointer-events:none; position:absolute; top:-8rem; left:-6rem; width:24rem; height:24rem; border-radius:9999px; background:rgba(14,165,233,0.2); filter:blur(100px);"></div>
        <div style="pointer-events:none; position:absolute; top:2.5rem; right:0; width:20rem; height:20rem; border-radius:9999px; background:rgba(2,132,199,0.1); filter:blur(100px);"></div>

        <div style="position:relative; max-width:72rem; margin:0 auto; padding:4rem 1.5rem 5rem;">
            <div class="bv-hero-grid">

                {{-- Left: copy --}}
                <div style="animation:bvFadeUp 0.6s ease forwards; opacity:0;">
                    <span style="display:inline-flex; align-items:center; gap:0.5rem; border-radius:9999px; background:#fff; border:1px solid #E3F1FB; padding:0.375rem 1rem; font-size:0.75rem; font-weight:500; color:#0284C7; box-shadow:0 8px 24px -8px rgba(14,165,233,0.25); font-family:'Inter',sans-serif;">
                        <svg style="width:0.875rem; height:0.875rem;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                        </svg>
                        Perpustakaan Digital Kampus
                    </span>

                    <h1 style="margin-top:1.5rem; font-family:'Fraunces',serif; letter-spacing:-0.02em; font-size:2.25rem; line-height:1.1; color:#0C2D3F;">
                        Temukan, pinjam, dan
                        <span style="color:transparent; -webkit-background-clip:text; background-clip:text; background-image:linear-gradient(to right,#0EA5E9,#0369A1);">jelajahi koleksi buku</span>
                        favoritmu
                    </h1>

                    <p style="margin-top:1.25rem; color:#5B7587; font-size:0.875rem; line-height:1.625; max-width:28rem; font-family:'Inter',sans-serif;">
                        BookVerse membantu kamu menemukan buku, mengelola peminjaman, dan menjaga jadwal pengembalian tetap rapi — semua dalam satu tempat.
                    </p>

                    {{-- Search --}}
                    <div class="bv-search" id="bvSearchWrap" style="margin-top:2rem; background:#fff; border-radius:9999px; border:1px solid #E3F1FB; padding:0.375rem 0.375rem 0.375rem 1.25rem; box-shadow:0 20px 45px -20px rgba(14,165,233,0.35); max-width:28rem; transition:border-color 0.2s;">
                        <svg style="width:1.125rem; height:1.125rem; color:#5B7587; flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5A6.5 6.5 0 114 10.5a6.5 6.5 0 0113 0z"/>
                        </svg>
                        <input
                            type="text"
                            placeholder="Cari judul, penulis, atau ISBN..."
                            style="width:100%; background:transparent; border:none; outline:none; font-size:0.875rem; color:#0C2D3F; padding:0.5rem 0; font-family:'Inter',sans-serif;"
                            onfocus="document.getElementById('bvSearchWrap').style.borderColor='#0EA5E9'"
                            onblur="document.getElementById('bvSearchWrap').style.borderColor='#E3F1FB'"
                        >
                        <button type="submit" style="flex-shrink:0; border-radius:9999px; background:linear-gradient(135deg,#0EA5E9,#0284C7); color:#fff; font-size:0.875rem; font-weight:500; padding:0.625rem 1.25rem; border:none; cursor:pointer; font-family:'Inter',sans-serif; box-shadow:0 10px 25px -8px rgba(2,132,199,0.6); transition:all 0.2s;"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 16px 30px -8px rgba(2,132,199,0.7)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 25px -8px rgba(2,132,199,0.6)'">
                            Cari
                        </button>
                    </div>

                    <div class="bv-tags" style="margin-top:1.5rem; font-size:0.75rem; color:#5B7587; font-family:'Inter',sans-serif;">
                        <span>Populer:</span>
                        <a href="#" style="border-radius:9999px; background:#fff; border:1px solid #E3F1FB; padding:0.25rem 0.75rem; color:#5B7587; text-decoration:none; transition:all 0.2s; font-size:0.75rem;"
                            onmouseover="this.style.borderColor='#0EA5E9'; this.style.color='#0284C7'"
                            onmouseout="this.style.borderColor='#E3F1FB'; this.style.color='#5B7587'">Fiksi</a>
                        <a href="#" style="border-radius:9999px; background:#fff; border:1px solid #E3F1FB; padding:0.25rem 0.75rem; color:#5B7587; text-decoration:none; transition:all 0.2s; font-size:0.75rem;"
                            onmouseover="this.style.borderColor='#0EA5E9'; this.style.color='#0284C7'"
                            onmouseout="this.style.borderColor='#E3F1FB'; this.style.color='#5B7587'">Sains</a>
                        <a href="#" style="border-radius:9999px; background:#fff; border:1px solid #E3F1FB; padding:0.25rem 0.75rem; color:#5B7587; text-decoration:none; transition:all 0.2s; font-size:0.75rem;"
                            onmouseover="this.style.borderColor='#0EA5E9'; this.style.color='#0284C7'"
                            onmouseout="this.style.borderColor='#E3F1FB'; this.style.color='#5B7587'">Sejarah</a>
                    </div>
                </div>

                {{-- Right: illustration card stack --}}
                <div class="bv-hero-illust" style="position:relative; animation:bvFadeUp 0.7s 0.1s ease forwards; opacity:0;">
                    <div style="position:relative; margin:0 auto; width:100%; max-width:24rem; aspect-ratio:4/5; border-radius:28px; background:#fff; border:1px solid #E3F1FB; box-shadow:0 40px 80px -30px rgba(14,165,233,0.4); padding:1.5rem; display:flex; flex-direction:column; justify-content:space-between;">
                        <div class="bv-card-row">
                            <span style="font-size:0.75rem; font-weight:500; color:#5B7587; font-family:'Inter',sans-serif;">Sedang Dipinjam</span>
                            <span style="border-radius:9999px; background:rgba(16,185,129,0.1); color:#10B981; font-size:0.6875rem; font-weight:500; padding:0.25rem 0.75rem; font-family:'Inter',sans-serif;">Aktif</span>
                        </div>

                        <div style="display:flex; flex-direction:column; gap:1rem;">
                            <div style="height:7rem; width:5rem; border-radius:0.75rem; background:linear-gradient(135deg,#0EA5E9,#0369A1); box-shadow:0 8px 20px -6px rgba(14,165,233,0.4);"></div>
                            <div>
                                <p style="font-family:'Fraunces',serif; font-size:1.125rem; color:#0C2D3F; line-height:1.375;">Filosofi Ilmu &<br>Metode Berpikir</p>
                                <p style="font-size:0.75rem; color:#5B7587; margin-top:0.25rem; font-family:'Inter',sans-serif;">Sujarwo Hadi &middot; 312 hlm</p>
                            </div>
                        </div>

                        <div class="bv-card-foot" style="font-size:0.75rem; color:#5B7587; font-family:'Inter',sans-serif;">
                            <span>Jatuh tempo</span>
                            <span style="font-weight:500; color:#0C2D3F;">12 Jul 2026</span>
                        </div>
                    </div>

                    {{-- floating badge card --}}
                    <div style="position:absolute; bottom:-1.5rem; left:-1.5rem; width:12rem; border-radius:1rem; background:#fff; border:1px solid #E3F1FB; box-shadow:0 25px 50px -20px rgba(14,165,233,0.35); padding:1rem;">
                        <div class="bv-badge-row">
                            <div style="width:2.5rem; height:2.5rem; border-radius:9999px; background:rgba(14,165,233,0.1); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <svg style="width:1.25rem; height:1.25rem; color:#0EA5E9;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                                </svg>
                            </div>
                            <div>
                                <p style="font-size:0.875rem; font-weight:600; color:#0C2D3F; font-family:'Inter',sans-serif;">12.480+</p>
                                <p style="font-size:0.6875rem; color:#5B7587; font-family:'Inter',sans-serif;">Judul buku</p>
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
    <section style="max-width:72rem; margin:0 auto; padding:1.5rem 1.5rem;">
        <div class="bv-stats-grid">
            @php
                $stats = [
                    ['label' => 'Total Koleksi', 'value' => '12.480', 'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25'],
                    ['label' => 'Anggota Aktif', 'value' => '3.216', 'icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z'],
                    ['label' => 'Sedang Dipinjam', 'value' => '842', 'icon' => 'M6 6.878V6a2.25 2.25 0 012.25-2.25h7.5A2.25 2.25 0 0118 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 004.5 9v.878m13.5-3A2.25 2.25 0 0119.5 9v.878m0 0a2.246 2.246 0 00-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0121 12v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6c0-1.007.66-1.86 1.569-2.147'],
                    ['label' => 'Kategori', 'value' => '36', 'icon' => 'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z'],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div style="border-radius:24px; background:#fff; border:1px solid #E3F1FB; box-shadow:0 20px 40px -28px rgba(14,165,233,0.35); padding:1.25rem; transition:transform 0.2s; cursor:default;"
                    onmouseover="this.style.transform='translateY(-4px)'"
                    onmouseout="this.style.transform='translateY(0)'">
                    <div class="bv-icon-box">
                        <svg style="width:1.25rem; height:1.25rem; color:#0EA5E9;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}"/>
                        </svg>
                    </div>
                    <p style="margin-top:1rem; font-family:'Fraunces',serif; font-size:1.5rem; color:#0C2D3F;">{{ $stat['value'] }}</p>
                    <p style="font-size:0.75rem; color:#5B7587; margin-top:0.25rem; font-family:'Inter',sans-serif;">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ==========================================================
         KATEGORI POPULER
    =========================================================== --}}
    <section style="max-width:72rem; margin:0 auto; padding:3.5rem 1.5rem;">
        <div class="bv-row" style="margin-bottom:1.5rem;">
            <div>
                <p style="font-size:0.75rem; font-weight:500; color:#0284C7; margin-bottom:0.5rem; font-family:'Inter',sans-serif;">Jelajahi</p>
                <h2 style="font-family:'Fraunces',serif; font-size:1.5rem; color:#0C2D3F;">Kategori Populer</h2>
            </div>
            <a href="#" style="font-size:0.875rem; color:#0284C7; font-weight:500; text-decoration:none; transition:color 0.2s; font-family:'Inter',sans-serif;"
                onmouseover="this.style.color='#0369A1'" onmouseout="this.style.color='#0284C7'">Lihat semua &rarr;</a>
        </div>

        <div class="bv-cats-grid">
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
                <a href="#" style="border-radius:1rem; background:#fff; border:1px solid #E3F1FB; padding:1.25rem; text-align:center; text-decoration:none; box-shadow:0 16px 32px -26px rgba(14,165,233,0.4); transition:all 0.2s; display:block;"
                    onmouseover="this.style.borderColor='#0EA5E9'; this.style.transform='translateY(-4px)'"
                    onmouseout="this.style.borderColor='#E3F1FB'; this.style.transform='translateY(0)'">
                    <p style="font-size:0.875rem; font-weight:500; color:#0C2D3F; font-family:'Inter',sans-serif;">{{ $cat['name'] }}</p>
                    <p style="font-size:0.6875rem; color:#5B7587; margin-top:0.25rem; font-family:'Inter',sans-serif;">{{ $cat['count'] }} judul</p>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ==========================================================
         BUKU TERBARU
    =========================================================== --}}
    <section style="max-width:72rem; margin:0 auto; padding:1.5rem 1.5rem 5rem;">
        <div class="bv-row" style="margin-bottom:1.5rem;">
            <div>
                <p style="font-size:0.75rem; font-weight:500; color:#0284C7; margin-bottom:0.5rem; font-family:'Inter',sans-serif;">Baru Ditambahkan</p>
                <h2 style="font-family:'Fraunces',serif; font-size:1.5rem; color:#0C2D3F;">Koleksi Terbaru</h2>
            </div>
            <a href="#" style="font-size:0.875rem; color:#0284C7; font-weight:500; text-decoration:none; transition:color 0.2s; font-family:'Inter',sans-serif;"
                onmouseover="this.style.color='#0369A1'" onmouseout="this.style.color='#0284C7'">Lihat katalog &rarr;</a>
        </div>

        <div class="bv-books-grid">
            @php
                $books = [
                    ['title' => 'Bumi Manusia', 'author' => 'Pramoedya A.T.', 'badge' => 'Fiksi', 'from' => '#0EA5E9', 'to' => '#0369A1'],
                    ['title' => 'Sapiens', 'author' => 'Yuval N. Harari', 'badge' => 'Sains', 'from' => '#38BDF8', 'to' => '#0284C7'],
                    ['title' => 'Laut Bercerita', 'author' => 'Leila S. Chudori', 'badge' => 'Fiksi', 'from' => '#0284C7', 'to' => '#0C2D3F'],
                    ['title' => 'Atomic Habits', 'author' => 'James Clear', 'badge' => 'Pengembangan Diri', 'from' => '#0EA5E9', 'to' => '#38BDF8'],
                ];
            @endphp

            @foreach ($books as $book)
                <div style="border-radius:24px; background:#fff; border:1px solid #E3F1FB; padding:1rem; box-shadow:0 20px 40px -28px rgba(14,165,233,0.35); transition:all 0.3s; cursor:default;"
                    onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 30px 50px -24px rgba(14,165,233,0.45)'; this.querySelector('.bv-btn-detail').style.background='linear-gradient(135deg,#0EA5E9,#0284C7)'; this.querySelector('.bv-btn-detail').style.color='#fff'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 20px 40px -28px rgba(14,165,233,0.35)'; this.querySelector('.bv-btn-detail').style.background='#F3F9FE'; this.querySelector('.bv-btn-detail').style.color='#0284C7'">
                    <div style="border-radius:1rem; height:10rem; width:100%; margin-bottom:1rem; box-shadow:inset 0 2px 8px rgba(0,0,0,0.06); background:linear-gradient(135deg, {{ $book['from'] }}, {{ $book['to'] }});"></div>
                    <span style="display:inline-block; border-radius:9999px; background:rgba(14,165,233,0.1); color:#0284C7; font-size:0.6875rem; font-weight:500; padding:0.25rem 0.75rem; margin-bottom:0.5rem; font-family:'Inter',sans-serif;">{{ $book['badge'] }}</span>
                    <p style="font-family:'Fraunces',serif; font-size:1rem; color:#0C2D3F; line-height:1.375;">{{ $book['title'] }}</p>
                    <p style="font-size:0.75rem; color:#5B7587; margin-top:0.25rem; font-family:'Inter',sans-serif;">{{ $book['author'] }}</p>

                    <button class="bv-btn-detail" style="margin-top:1rem; width:100%; border-radius:9999px; background:#F3F9FE; color:#0284C7; font-size:0.75rem; font-weight:500; padding:0.625rem 0; border:none; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s;">
                        Lihat Detail
                    </button>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ==========================================================
         CTA
    =========================================================== --}}
    <section style="max-width:72rem; margin:0 auto; padding:0 1.5rem 5rem;">
        <div style="position:relative; overflow:hidden; border-radius:28px; background:linear-gradient(to right,#0EA5E9,#0369A1); padding:3.5rem 2rem; text-align:center; box-shadow:0 40px 80px -30px rgba(3,105,161,0.5);">
            <div style="pointer-events:none; position:absolute; inset:0; opacity:0.08; background-image:radial-gradient(circle, #fff 1px, transparent 1px); background-size:22px 22px;"></div>
            <h2 style="position:relative; font-family:'Fraunces',serif; font-size:1.875rem; color:#fff; line-height:1.25;">
                Belum punya akun anggota?
            </h2>
            <p style="position:relative; color:rgba(255,255,255,0.8); font-size:0.875rem; margin-top:0.75rem; max-width:28rem; margin-left:auto; margin-right:auto; font-family:'Inter',sans-serif; line-height:1.625;">
                Daftar sekarang dan mulai pinjam buku favoritmu dari koleksi BookVerse.
            </p>
            <a href="{{ route('register') }}" style="position:relative; display:inline-block; margin-top:1.75rem; border-radius:9999px; background:#fff; color:#0284C7; font-size:0.875rem; font-weight:500; padding:0.75rem 1.75rem; text-decoration:none; box-shadow:0 8px 24px -6px rgba(0,0,0,0.15); transition:transform 0.2s; font-family:'Inter',sans-serif;"
                onmouseover="this.style.transform='translateY(-2px)'"
                onmouseout="this.style.transform='translateY(0)'">
                Daftar Sekarang
            </a>
        </div>
    </section>

</div>
@endsection