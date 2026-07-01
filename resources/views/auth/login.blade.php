@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    /* ═══════════ BASE ═══════════ */
    .login-page {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        background: #f3f9fe;
        min-height: calc(100vh - 4rem);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1.5rem;
        position: relative;
        overflow: hidden;
    }

    /* ═══════════ AMBIENT BACKGROUND ═══════════ */
    .ambient-wash {
        position: fixed; inset: 0; z-index: 0;
        background:
            radial-gradient(ellipse 800px 500px at 15% 0%, rgba(56,189,248,0.18), transparent 60%),
            radial-gradient(ellipse 700px 600px at 100% 100%, rgba(14,165,233,0.14), transparent 60%),
            radial-gradient(ellipse 500px 400px at 90% 10%, rgba(125,211,252,0.16), transparent 60%);
    }
    .dot-field {
        position: fixed; inset: 0; z-index: 0;
        background-image: radial-gradient(rgba(14,116,144,0.08) 1px, transparent 1px);
        background-size: 26px 26px;
        mask-image: radial-gradient(ellipse 70% 70% at 50% 40%, black 0%, transparent 75%);
        -webkit-mask-image: radial-gradient(ellipse 70% 70% at 50% 40%, black 0%, transparent 75%);
    }

    /* drifting page motes */
    .mote {
        position: fixed;
        bottom: -5%;
        border-radius: 2px;
        background: rgba(14,165,233,0.12);
        border: 1px solid rgba(14,165,233,0.18);
        z-index: 0;
        animation: moteRise linear infinite;
    }
    @keyframes moteRise {
        0% { transform: translateY(0) rotate(0deg); opacity: 0; }
        12% { opacity: 0.8; }
        88% { opacity: 0.5; }
        100% { transform: translateY(-115vh) rotate(40deg); opacity: 0; }
    }

    /* ═══════════ WRAPPER ═══════════ */
    .auth-wrap {
        position: relative;
        z-index: 10;
        width: 100%;
        max-width: 430px;
        opacity: 0;
        transform: translateY(28px);
        animation: wrapIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.1s forwards;
    }
    @keyframes wrapIn { to { opacity: 1; transform: translateY(0); } }

    /* ═══════════ ILLUSTRATION HEADER ═══════════ */
    .illus-header { text-align: center; margin-bottom: 1.75rem; }

    .open-book {
        position: relative;
        width: 96px; height: 64px;
        margin: 0 auto 1.1rem;
        filter: drop-shadow(0 14px 24px rgba(14,116,144,0.25));
    }
    .open-book .glow {
        position: absolute;
        left: 50%; top: 40%;
        transform: translate(-50%, -50%);
        width: 140px; height: 140px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(56,189,248,0.30), transparent 70%);
        animation: glowPulse 3.2s ease-in-out infinite;
    }
    @keyframes glowPulse {
        0%, 100% { opacity: 0.55; transform: translate(-50%, -50%) scale(1); }
        50% { opacity: 1; transform: translate(-50%, -50%) scale(1.12); }
    }
    .page-left, .page-right {
        position: absolute;
        bottom: 4px;
        width: 44px; height: 56px;
        background: linear-gradient(135deg, #ffffff, #e0f2fe);
        box-shadow: 0 6px 16px rgba(14,116,144,0.18);
    }
    .page-left {
        left: 50%; margin-left: -44px;
        border-radius: 6px 2px 2px 6px;
        transform-origin: right bottom;
        transform: perspective(200px) rotateY(-22deg);
        background: linear-gradient(225deg, #ffffff, #dceffc);
    }
    .page-right {
        right: 50%; margin-right: -44px;
        border-radius: 2px 6px 6px 2px;
        transform-origin: left bottom;
        transform: perspective(200px) rotateY(22deg);
    }
    .page-left::before, .page-right::before {
        content: '';
        position: absolute;
        top: 12px; left: 8px; right: 8px;
        height: 1.5px;
        background: rgba(14,116,144,0.14);
        box-shadow: 0 7px 0 rgba(14,116,144,0.11), 0 14px 0 rgba(14,116,144,0.09), 0 21px 0 rgba(14,116,144,0.07), 0 28px 0 rgba(14,116,144,0.05);
    }
    .book-spine {
        position: absolute;
        left: 50%; bottom: 2px;
        transform: translateX(-50%);
        width: 6px; height: 58px;
        background: linear-gradient(180deg, #0ea5e9, #0369a1);
        border-radius: 3px;
        box-shadow: 0 4px 10px rgba(3,105,161,0.4);
    }
    .book-wing {
        position: absolute;
        bottom: 4px;
        width: 14px; height: 50px;
        background: linear-gradient(135deg, #38bdf8, #0ea5e9);
        opacity: 0.85;
    }
    .book-wing.left { left: 50%; margin-left: -56px; border-radius: 5px 0 0 3px; transform: skewY(8deg); }
    .book-wing.right { right: 50%; margin-right: -56px; border-radius: 0 5px 3px 0; transform: skewY(-8deg); }

    .auth-eyebrow {
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: #0ea5e9;
        margin-bottom: 0.4rem;
    }
    .auth-title {
        font-family: 'Fraunces', Georgia, serif;
        font-size: 2.1rem;
        font-weight: 600;
        color: #0c2d3f;
        letter-spacing: -0.01em;
        line-height: 1.1;
    }
    .auth-sub {
        color: #5b7587;
        font-size: 0.88rem;
        margin-top: 0.55rem;
    }

    /* ═══════════ CARD ═══════════ */
    .auth-card {
        background: #ffffff;
        border-radius: 26px;
        padding: 2.5rem 2.25rem;
        border: 1px solid #e3f1fb;
        box-shadow:
            0 1px 0 rgba(255,255,255,0.8) inset,
            0 24px 60px -22px rgba(7,89,133,0.22);
        position: relative;
    }

    /* bookmark ribbon accent */
    .ribbon {
        position: absolute;
        top: -2px; right: 28px;
        width: 26px; height: 46px;
        background: linear-gradient(180deg, #0ea5e9, #0284c7);
        clip-path: polygon(0 0, 100% 0, 100% 100%, 50% 78%, 0 100%);
        box-shadow: 0 8px 14px -6px rgba(2,132,199,0.5);
    }

    .stagger > * {
        opacity: 0;
        transform: translateY(14px);
        animation: staggerUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .stagger > *:nth-child(1) { animation-delay: 0.30s; }
    .stagger > *:nth-child(2) { animation-delay: 0.36s; }
    .stagger > *:nth-child(3) { animation-delay: 0.42s; }
    .stagger > *:nth-child(4) { animation-delay: 0.48s; }
    .stagger > *:nth-child(5) { animation-delay: 0.54s; }
    @keyframes staggerUp { to { opacity: 1; transform: translateY(0); } }

    /* ═══════════ UNDERLINE INPUTS ═══════════ */
    .field { margin-bottom: 1.6rem; }
    .field-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.45rem;
    }
    .field-label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #0c4a6e;
    }
    .field-shell {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        border-bottom: 2px solid #e2eef6;
        padding-bottom: 0.6rem;
        transition: border-color 0.25s ease;
    }
    .field-shell:focus-within { border-color: #0ea5e9; }
    .field-shell.has-error { border-color: #f87171; }
    .field-shell svg { color: #94c0d9; flex-shrink: 0; transition: color 0.25s ease; }
    .field-shell:focus-within svg { color: #0ea5e9; }
    .field-shell input {
        flex: 1;
        border: none;
        outline: none;
        background: transparent;
        font-family: inherit;
        font-size: 0.96rem;
        color: #0c2d3f;
        padding: 0.1rem 0;
    }
    .field-shell input::placeholder { color: #b4cbda; }
    .toggle-pw {
        background: none; border: none; cursor: pointer;
        color: #94c0d9; padding: 2px; display: flex;
        transition: color 0.2s;
    }
    .toggle-pw:hover { color: #0ea5e9; }
    .field-error {
        font-size: 0.74rem;
        color: #ef4444;
        margin-top: 0.45rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
        animation: errorShake 0.4s ease;
    }
    @keyframes errorShake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-4px); }
        75% { transform: translateX(4px); }
    }

    /* ═══════════ CHECKBOX ═══════════ */
    .custom-check {
        display: inline-flex; align-items: center; gap: 0.55rem;
        cursor: pointer; user-select: none;
    }
    .custom-check input { position: absolute; opacity: 0; width: 0; height: 0; }
    .check-mark {
        width: 17px; height: 17px;
        border: 1.5px solid #cfe3f0;
        border-radius: 5px;
        display: grid; place-items: center;
        transition: all 0.22s ease;
        background: #f6fbfe;
        flex-shrink: 0;
    }
    .custom-check input:checked + .check-mark {
        background: #0ea5e9; border-color: #0ea5e9;
        box-shadow: 0 0 0 4px rgba(14,165,233,0.14);
    }
    .check-mark svg {
        width: 10px; height: 10px; stroke: #fff; stroke-width: 3.2; fill: none;
        opacity: 0; transform: scale(0.5);
        transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .custom-check input:checked + .check-mark svg { opacity: 1; transform: scale(1); }
    .check-text { font-size: 0.81rem; color: #5b7587; }

    /* ═══════════ SUBMIT BUTTON — PILL ═══════════ */
    .btn-submit {
        width: 100%;
        padding: 0.95rem 1.5rem;
        border: none;
        border-radius: 999px;
        font-size: 0.92rem;
        font-weight: 700;
        font-family: inherit;
        color: #ffffff;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        background: linear-gradient(95deg, #0ea5e9, #0284c7);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-submit::before {
        content: '';
        position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.7s ease;
    }
    .btn-submit:hover::before { left: 100%; }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 14px 28px -10px rgba(2,132,199,0.55); }
    .btn-submit:active { transform: translateY(0) scale(0.98); }
    .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none !important; box-shadow: none !important; }
    .btn-inner { display: flex; align-items: center; justify-content: center; gap: 0.5rem; position: relative; z-index: 2; }
    .btn-arrow { transition: transform 0.3s ease; }
    .btn-submit:hover .btn-arrow { transform: translateX(3px); }
    .btn-spinner {
        display: none; width: 17px; height: 17px;
        border: 2.5px solid rgba(255,255,255,0.35); border-top-color: #fff;
        border-radius: 50%; animation: fastSpin 0.55s linear infinite;
    }
    .btn-submit.is-loading .btn-spinner { display: block; }
    .btn-submit.is-loading .btn-label { display: none; }
    @keyframes fastSpin { to { transform: rotate(360deg); } }

    /* ═══════════ ALERT ═══════════ */
    .alert-box {
        margin-bottom: 1.3rem;
        padding: 0.8rem 1rem;
        border-radius: 13px;
        display: flex; align-items: flex-start; gap: 0.6rem;
        background: #fef2f2; border: 1px solid #fecaca;
        animation: alertIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes alertIn { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
    .alert-icon { color: #ef4444; flex-shrink: 0; margin-top: 1px; }
    .alert-text { color: #b91c1c; font-size: 0.84rem; line-height: 1.5; }

    /* ═══════════ MISC ═══════════ */
    .row-between { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.85rem; }
    .link-accent {
        color: #0ea5e9; text-decoration: none; font-weight: 600; position: relative;
    }
    .link-accent::after {
        content: ''; position: absolute; bottom: -2px; left: 0; width: 0; height: 1.5px;
        background: #0284c7; border-radius: 1px; transition: width 0.3s ease;
    }
    .link-accent:hover::after { width: 100%; }
    .auth-footer { text-align: center; font-size: 0.83rem; color: #5b7587; margin-top: 1.6rem; }

    @media (max-width: 480px) {
        .auth-card { padding: 2rem 1.6rem; }
        .auth-title { font-size: 1.75rem; }
        .mote { display: none; }
    }
</style>

<div class="login-page">
    <div class="ambient-wash"></div>
    <div class="dot-field"></div>

    <div class="mote" style="left:10%;width:10px;height:13px;animation-duration:16s;animation-delay:0s;transform:rotate(-12deg);"></div>
    <div class="mote" style="left:24%;width:8px;height:10px;animation-duration:13s;animation-delay:3s;transform:rotate(20deg);"></div>
    <div class="mote" style="left:72%;width:11px;height:14px;animation-duration:18s;animation-delay:1s;transform:rotate(-8deg);"></div>
    <div class="mote" style="left:86%;width:9px;height:11px;animation-duration:15s;animation-delay:5s;transform:rotate(15deg);"></div>
    <div class="mote" style="left:50%;width:7px;height:9px;animation-duration:14s;animation-delay:7s;transform:rotate(-20deg);"></div>

    <div class="auth-wrap">

        <!-- ── Illustration + Heading ── -->
        <div class="illus-header">
            <div class="open-book">
                <div class="glow"></div>
                <div class="book-wing left"></div>
                <div class="book-wing right"></div>
                <div class="page-left"></div>
                <div class="page-right"></div>
                <div class="book-spine"></div>
            </div>
            <div class="auth-eyebrow">BookVerse</div>
            <h1 class="auth-title">Lanjutkan ceritamu</h1>
            <p class="auth-sub">Masuk untuk kembali ke rak buku dan progres bacaanmu.</p>
        </div>

        <!-- ── Card ── -->
        <div class="auth-card">
            <div class="ribbon"></div>

            <div class="stagger">

                @if (session('error'))
                    <div class="alert-box">
                        <svg class="alert-icon w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                        <span class="alert-text">{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-box">
                        <svg class="alert-icon w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                        <ul class="alert-text space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="loginForm" action="{{ route('login') }}" method="POST" novalidate>
                    @csrf

                    <!-- Email -->
                    <div class="field">
                        <div class="field-top"><span class="field-label">Email</span></div>
                        <div class="field-shell {{ $errors->has('email') ? 'has-error' : '' }}">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                            </svg>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" autocomplete="email">
                        </div>
                        @if ($errors->has('email'))
                            <div class="field-error">
                                <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <!-- Password -->
                    <div class="field">
                        <div class="field-shell {{ $errors->has('password') ? 'has-error' : '' }}">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                            <input type="password" id="password" name="password" required placeholder="••••••••">
                            <button type="button" class="toggle-pw" onclick="togglePassword()" aria-label="Tampilkan password">
                                <svg id="iconEyeOff" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                </svg>
                                <svg id="iconEyeOn" class="hidden" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </button>
                        </div>
                        @if ($errors->has('password'))
                            <div class="field-error">
                                <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>

                    <!-- Remember -->
                    <div class="row-between">
                        <label class="custom-check">
                            <input type="checkbox" name="remember" id="remember">
                            <span class="check-mark">
                                <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span class="check-text">Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <div class="btn-inner">
                            <span class="btn-label">Masuk</span>
                            <svg class="btn-arrow btn-label" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                            <div class="btn-spinner"></div>
                        </div>
                    </button>
                </form>
            </div>
        </div>

        <p class="auth-footer">
            Belum punya akun? <a href="{{ route('register') }}" class="link-accent">Daftar sekarang</a>
        </p>

    </div>
</div>

<script>
    function togglePassword() {
        const pw = document.getElementById('password');
        const off = document.getElementById('iconEyeOff');
        const on = document.getElementById('iconEyeOn');
        if (pw.type === 'password') {
            pw.type = 'text';
            off.classList.add('hidden');
            on.classList.remove('hidden');
        } else {
            pw.type = 'password';
            off.classList.remove('hidden');
            on.classList.add('hidden');
        }
    }

    document.getElementById('loginForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.classList.add('is-loading');
    });
</script>
@endsection