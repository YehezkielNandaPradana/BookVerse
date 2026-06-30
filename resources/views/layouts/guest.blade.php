{{-- layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BookVerse') — BookVerse</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <style>
        @keyframes bvGlowA {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.05); }
        }
        @keyframes bvGlowB {
            0%, 100% { opacity: 0.35; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.04); }
        }
        @keyframes bvFadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes bvShine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
    </style>
</head>
<body style="min-height:100vh; margin:0; padding:0; background-color:#F3F9FE; font-family:'Inter',sans-serif;">

    {{-- Background Layer — semua inline style, tidak pakai class kustom --}}
    <div style="position:fixed; inset:0; pointer-events:none; z-index:0; overflow:hidden;" aria-hidden="true">
        <div style="position:absolute; inset:0; background:radial-gradient(ellipse 60% 50% at 50% 0%, rgba(14,165,233,0.08) 0%, transparent 70%);"></div>
        <div style="position:absolute; inset:0; background-image:radial-gradient(circle, rgba(14,165,233,0.07) 1px, transparent 1px); background-size:28px 28px;"></div>
        <div style="position:absolute; top:-8rem; right:-8rem; width:24rem; height:24rem; border-radius:9999px; background:radial-gradient(circle, rgba(14,165,233,0.12) 0%, transparent 70%); filter:blur(60px); animation:bvGlowA 6s ease-in-out infinite;"></div>
        <div style="position:absolute; bottom:-10rem; left:-10rem; width:31.25rem; height:31.25rem; border-radius:9999px; background:radial-gradient(circle, rgba(14,165,233,0.08) 0%, transparent 70%); filter:blur(80px); animation:bvGlowB 8s ease-in-out 2s infinite;"></div>
    </div>

    {{-- Content --}}
    <div style="position:relative; z-index:1; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:3rem 1.5rem;">
        @yield('content')
    </div>

    @stack('scripts')

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const eyeOpen = button.querySelector('.eye-open');
            const eyeClosed = button.querySelector('.eye-closed');
            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
</body>
</html>