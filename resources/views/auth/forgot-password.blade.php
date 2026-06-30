@extends('layouts.guest')

@section('title', 'Lupa Password')

@section('content')
<style>
    /* Animated gradient background */
    .gradient-bg {
        background: linear-gradient(-45deg, #0f0c29, #302b63, #24243e, #1a1a2e);
        background-size: 400% 400%;
        animation: gradientShift 12s ease infinite;
    }
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Floating orbs */
    .orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.3;
        animation: float 8s ease-in-out infinite;
    }
    .orb-1 {
        width: 300px; height: 300px;
        background: #6366f1;
        top: -80px; left: -60px;
        animation-delay: 0s;
    }
    .orb-2 {
        width: 250px; height: 250px;
        background: #ec4899;
        bottom: -50px; right: -40px;
        animation-delay: -3s;
    }
    .orb-3 {
        width: 200px; height: 200px;
        background: #06b6d4;
        top: 40%; left: 60%;
        animation-delay: -5s;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0px) scale(1); }
        50% { transform: translateY(-30px) scale(1.05); }
    }

    /* Glass card */
    .glass-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow:
            0 8px 32px rgba(0, 0, 0, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    /* Glow button */
    .btn-glow {
        background: linear-gradient(135deg, #6366f1, #8b5cf6, #a855f7);
        background-size: 200% 200%;
        animation: btnGradient 4s ease infinite;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .btn-glow::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }
    .btn-glow:hover::before {
        left: 100%;
    }
    .btn-glow:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(99, 102, 241, 0.5);
    }
    .btn-glow:active {
        transform: translateY(0);
    }
    @keyframes btnGradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Input glass */
    .input-glass {
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #f1f5f9;
        transition: all 0.3s ease;
    }
    .input-glass::placeholder {
        color: rgba(255, 255, 255, 0.35);
    }
    .input-glass:focus {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(99, 102, 241, 0.6);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15), 0 0 20px rgba(99, 102, 241, 0.1);
        outline: none;
    }

    /* Icon container pulse */
    .icon-ring {
        position: relative;
    }
    .icon-ring::before {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        background: conic-gradient(from 0deg, #6366f1, #ec4899, #06b6d4, #6366f1);
        animation: spin 4s linear infinite;
        opacity: 0.6;
    }
    .icon-ring::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        background: conic-gradient(from 0deg, #6366f1, #ec4899, #06b6d4, #6366f1);
        animation: spin 4s linear infinite;
        filter: blur(12px);
        opacity: 0.4;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    .icon-inner {
        position: relative;
        z-index: 1;
        background: #1a1a2e;
        border-radius: 50%;
    }

    /* Particles */
    .particle {
        position: absolute;
        width: 3px; height: 3px;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 50%;
        animation: particleFloat linear infinite;
    }
    @keyframes particleFloat {
        0% { transform: translateY(0) translateX(0); opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { transform: translateY(-400px) translateX(var(--drift)); opacity: 0; }
    }

    /* Alert animations */
    .alert-enter {
        animation: alertSlide 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes alertSlide {
        from { opacity: 0; transform: translateY(-10px) scale(0.97); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Link hover underline */
    .link-underline {
        position: relative;
    }
    .link-underline::after {
        content: '';
        position: absolute;
        bottom: -2px; left: 0;
        width: 0; height: 1.5px;
        background: linear-gradient(90deg, #818cf8, #c084fc);
        transition: width 0.3s ease;
    }
    .link-underline:hover::after {
        width: 100%;
    }

    /* Grid lines decoration */
    .grid-lines {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
        background-size: 60px 60px;
        pointer-events: none;
    }

    /* Loading spinner */
    .spinner {
        display: none;
        width: 20px; height: 20px;
        border: 2px solid rgba(255,255,255,0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spinFast 0.6s linear infinite;
    }
    .loading .spinner { display: block; }
    .loading .btn-text { display: none; }
    @keyframes spinFast {
        to { transform: rotate(360deg); }
    }
</style>

<div class="gradient-bg min-h-[calc(100vh-4rem)] flex items-center justify-center px-6 py-10 relative overflow-hidden">

    <!-- Decorative layers -->
    <div class="grid-lines"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <!-- Particles -->
    <div class="particle" style="left:10%; bottom:5%; --drift:40px; animation-duration:7s; animation-delay:0s;"></div>
    <div class="particle" style="left:25%; bottom:10%; --drift:-30px; animation-duration:9s; animation-delay:1s;"></div>
    <div class="particle" style="left:45%; bottom:0%; --drift:50px; animation-duration:8s; animation-delay:2s;"></div>
    <div class="particle" style="left:65%; bottom:8%; --drift:-45px; animation-duration:10s; animation-delay:0.5s;"></div>
    <div class="particle" style="left:80%; bottom:3%; --drift:35px; animation-duration:7.5s; animation-delay:3s;"></div>
    <div class="particle" style="left:90%; bottom:12%; --drift:-25px; animation-duration:8.5s; animation-delay:1.5s;"></div>
    <div class="particle" style="left:5%; bottom:15%; --drift:55px; animation-duration:11s; animation-delay:4s;"></div>
    <div class="particle" style="left:55%; bottom:2%; --drift:-60px; animation-duration:9.5s; animation-delay:2.5s;"></div>

    <!-- Card -->
    <div class="w-full max-w-md relative z-10">
        <div class="glass-card rounded-3xl overflow-hidden">

            <!-- Top accent line -->
            <div class="h-[2px] w-full" style="background: linear-gradient(90deg, transparent, #6366f1, #ec4899, #06b6d4, transparent);"></div>

            <div class="px-8 sm:px-10 py-10 sm:py-12">

                <!-- Header -->
                <div class="text-center mb-10">
                    <div class="inline-flex items-center justify-center mb-6">
                        <div class="icon-ring w-[72px] h-[72px] flex items-center justify-center">
                            <div class="icon-inner w-[60px] h-[60px] flex items-center justify-center">
                                <svg class="w-7 h-7 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">Lupa Password?</h1>
                    <p class="text-slate-400 mt-2 text-sm leading-relaxed max-w-xs mx-auto">
                        Jangan khawatir. Masukkan email Anda dan kami akan mengirimkan link untuk mengatur ulang password.
                    </p>
                </div>

                <!-- Alerts -->
                @if (session('error'))
                    <div class="alert-enter mb-5 p-4 rounded-xl bg-red-500/10 border border-red-500/20 flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                        <p class="text-red-300 text-sm">{{ session('error') }}</p>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert-enter mb-5 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-emerald-300 text-sm">{{ session('success') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-enter mb-5 p-4 rounded-xl bg-red-500/10 border border-red-500/20 flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                        <ul class="text-red-300 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form id="resetForm" action="{{ route('password.email') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-300 mb-2.5">Alamat Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-500 group-focus-within:text-indigo-400 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="input-glass w-full pl-12 pr-4 py-3.5 rounded-xl text-sm sm:text-base"
                                placeholder="nama@contoh.com"
                                autocomplete="email">
                        </div>
                        @if ($errors->has('email'))
                            <p class="mt-2 text-xs text-red-400 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $errors->first('email') }}
                            </p>
                        @endif
                    </div>

                    <div id="submitBtn" class="pt-1">
                        <button type="submit"
                            class="btn-glow w-full flex justify-center items-center py-3.5 px-4 rounded-xl text-sm font-semibold text-white tracking-wide">
                            <span class="btn-text">Kirim Link Reset</span>
                            <div class="spinner"></div>
                        </button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="flex items-center gap-4 my-8">
                    <div class="flex-1 h-px bg-white/10"></div>
                    <span class="text-xs text-slate-500 uppercase tracking-widest">atau</span>
                    <div class="flex-1 h-px bg-white/10"></div>
                </div>

                <!-- Back to login -->
                <div class="text-center text-sm text-slate-400">
                    Sudah ingat password Anda?
                    <a href="{{ route('login') }}" class="link-underline font-semibold text-indigo-400 hover:text-indigo-300 transition-colors ml-1">
                        Kembali Masuk
                    </a>
                </div>
            </div>

            <!-- Bottom accent line -->
            <div class="h-px w-full" style="background: linear-gradient(90deg, transparent, rgba(255,255,255,0.08), transparent);"></div>
        </div>

        <!-- Subtle branding text -->
        <p class="text-center text-xs text-white/15 mt-6 tracking-wider uppercase">
            Secure &bull; Encrypted &bull; Protected
        </p>
    </div>
</div>

<script>
    // Loading state on submit
    document.getElementById('resetForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        const button = btn.querySelector('button');
        button.disabled = true;
        btn.classList.add('loading');
    });

    // Subtle parallax on mouse move
    document.addEventListener('mousemove', function(e) {
        const card = document.querySelector('.glass-card');
        const rect = card.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;
        const deltaX = (e.clientX - centerX) / window.innerWidth;
        const deltaY = (e.clientY - centerY) / window.innerHeight;

        card.style.transform = `perspective(1000px) rotateY(${deltaX * 3}deg) rotateX(${-deltaY * 3}deg)`;
        card.style.transition = 'transform 0.1s ease-out';
    });

    // Reset card tilt on mouse leave
    document.addEventListener('mouseleave', function() {
        const card = document.querySelector('.glass-card');
        card.style.transform = 'perspective(1000px) rotateY(0deg) rotateX(0deg)';
        card.style.transition = 'transform 0.5s ease-out';
    });
</script>
@endsection