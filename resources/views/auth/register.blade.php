{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div style="width:100%; max-width:28rem; animation:bvFadeUp 0.7s cubic-bezier(0.22,1,0.36,1) forwards; position:relative;">
    <a href="{{ route('beranda') }}" style="position:absolute; top:-3.5rem; right:0; display:inline-flex; align-items:center; gap:0.45rem; padding:0.6rem 1.25rem; border-radius:9999px; background:linear-gradient(135deg,#ffffff,#e0f2fe); border:1px solid #bae6fd; color:#0EA5E9; font-size:0.82rem; font-weight:600; text-decoration:none; transition:all 0.3s cubic-bezier(0.4,0,0.2,1); box-shadow:0 4px 12px -2px rgba(14,165,233,0.15);" onmouseover="this.style.background='linear-gradient(135deg,#e0f2fe,#ffffff)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px -4px rgba(14,165,233,0.25)'; this.style.color='#0284C7'" onmouseout="this.style.background='linear-gradient(135deg,#ffffff,#e0f2fe)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px -2px rgba(14,165,233,0.15)'; this.style.color='#0EA5E9'">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.278 11.503a3 3 0 0 1 0-3.006l7.592-6.667a3 3 0 0 1 3.36 0l7.592 6.667a3 3 0 0 1 0 3.006l-7.592 6.667a3 3 0 0 1-3.36 0L2.278 11.503z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/>
        </svg>
        Beranda
    </a>
    <div style="background:#fff; border-radius:28px; border:1px solid #E3F1FB; box-shadow:0 24px 80px -20px rgba(14,165,233,0.15), 0 8px 24px -8px rgba(0,0,0,0.04); padding:2.5rem;">

        {{-- Header --}}
        <div style="text-align:center; margin-bottom:2.5rem;">
            <div style="display:inline-flex; align-items:center; justify-content:center; width:4rem; height:4rem; border-radius:1rem; margin-bottom:1.25rem; background:linear-gradient(135deg,#E0F2FE,#F0F9FF);">
                <svg style="width:2rem; height:2rem; color:#0EA5E9;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <h1 style="margin:0; font-size:1.5rem; font-weight:600; letter-spacing:-0.02em; color:#0C2D3F; font-family:'Fraunces',serif;">Buat Akun Baru</h1>
            <p style="margin-top:0.5rem; font-size:0.875rem; color:#5B7587; font-family:'Inter',sans-serif;">Daftar untuk mengakses BookVerse</p>
        </div>

        {{-- Error Session --}}
        @if (session('error'))
            <div style="background:linear-gradient(135deg,#FEF2F2,#FFF1F2); border:1px solid #FECACA; border-radius:16px; margin-bottom:1.5rem; padding:1rem; display:flex; align-items:flex-start; gap:0.75rem;">
                <svg style="width:1.25rem; height:1.25rem; margin-top:0.125rem; flex-shrink:0; color:#EF4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
                <p style="margin:0; font-size:0.875rem; color:#EF4444;">{{ session('error') }}</p>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div style="background:linear-gradient(135deg,#FEF2F2,#FFF1F2); border:1px solid #FECACA; border-radius:16px; margin-bottom:1.5rem; padding:1rem; display:flex; align-items:flex-start; gap:0.75rem;">
                <svg style="width:1.25rem; height:1.25rem; margin-top:0.125rem; flex-shrink:0; color:#EF4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
                <ul style="margin:0; padding:0; list-style:disc inside; font-size:0.875rem; color:#EF4444;">
                    @foreach ($errors->all() as $error)
                        <li style="margin-bottom:0.25rem;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('register') }}" method="POST" style="display:flex; flex-direction:column; gap:1.75rem;">
            @csrf

            {{-- Nama Lengkap --}}
            <div>
                <label for="name" style="display:block; font-size:0.75rem; font-weight:500; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.75rem; color:#5B7587;">Nama Lengkap</label>
                <div style="position:relative;">
                    <svg style="position:absolute; left:0; top:50%; transform:translateY(-50%); width:1.25rem; height:1.25rem; color:#9BB5C7;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        style="width:100%; padding:0.75rem 0 0.75rem 2.25rem; font-size:0.875rem; font-family:'Inter',sans-serif; color:#0C2D3F; background:transparent; border:none; border-bottom:2px solid #E3F1FB; outline:none; transition:border-color 0.3s;"
                        onfocus="this.style.borderBottomColor='#0EA5E9'"
                        onblur="this.style.borderBottomColor='#E3F1FB'"
                        placeholder="Masukkan nama lengkap Anda">
                </div>
                @if ($errors->has('name'))
                    <p style="margin-top:0.375rem; font-size:0.75rem; color:#EF4444; display:flex; align-items:center; gap:0.25rem;">
                        <svg style="width:0.875rem; height:0.875rem; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>

            {{-- Email --}}
            <div>
                <label for="email" style="display:block; font-size:0.75rem; font-weight:500; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.75rem; color:#5B7587;">Email</label>
                <div style="position:relative;">
                    <svg style="position:absolute; left:0; top:50%; transform:translateY(-50%); width:1.25rem; height:1.25rem; color:#9BB5C7;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        style="width:100%; padding:0.75rem 0 0.75rem 2.25rem; font-size:0.875rem; font-family:'Inter',sans-serif; color:#0C2D3F; background:transparent; border:none; border-bottom:2px solid #E3F1FB; outline:none; transition:border-color 0.3s;"
                        onfocus="this.style.borderBottomColor='#0EA5E9'"
                        onblur="this.style.borderBottomColor='#E3F1FB'"
                        placeholder="nama@contoh.com">
                </div>
                @if ($errors->has('email'))
                    <p style="margin-top:0.375rem; font-size:0.75rem; color:#EF4444; display:flex; align-items:center; gap:0.25rem;">
                        <svg style="width:0.875rem; height:0.875rem; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                        {{ $errors->first('email') }}
                    </p>
                @endif
            </div>

            {{-- Nomor Telepon --}}
            <div>
                <label for="phone" style="display:block; font-size:0.75rem; font-weight:500; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.75rem; color:#5B7587;">
                    Nomor Telepon
                    <span style="text-transform:none; letter-spacing:normal; font-weight:400; color:#9BB5C7;">(Opsional)</span>
                </label>
                <div style="position:relative;">
                    <svg style="position:absolute; left:0; top:50%; transform:translateY(-50%); width:1.25rem; height:1.25rem; color:#9BB5C7;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                    </svg>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                        style="width:100%; padding:0.75rem 0 0.75rem 2.25rem; font-size:0.875rem; font-family:'Inter',sans-serif; color:#0C2D3F; background:transparent; border:none; border-bottom:2px solid #E3F1FB; outline:none; transition:border-color 0.3s;"
                        onfocus="this.style.borderBottomColor='#0EA5E9'"
                        onblur="this.style.borderBottomColor='#E3F1FB'"
                        placeholder="08xx xxxx xxxx">
                </div>
            </div>

            {{-- Password --}}
            <div>
                <label for="password" style="display:block; font-size:0.75rem; font-weight:500; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.75rem; color:#5B7587;">Password</label>
                <div style="position:relative;">
                    <svg style="position:absolute; left:0; top:50%; transform:translateY(-50%); width:1.25rem; height:1.25rem; color:#9BB5C7;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                    <input type="password" id="password" name="password" required
                        style="width:100%; padding:0.75rem 2.5rem 0.75rem 2.25rem; font-size:0.875rem; font-family:'Inter',sans-serif; color:#0C2D3F; background:transparent; border:none; border-bottom:2px solid #E3F1FB; outline:none; transition:border-color 0.3s;"
                        onfocus="this.style.borderBottomColor='#0EA5E9'"
                        onblur="this.style.borderBottomColor='#E3F1FB'"
                        placeholder="Buat password">
                    <button type="button" onclick="togglePassword('password', this)" style="position:absolute; right:0; top:50%; transform:translateY(-50%); padding:0.375rem; background:none; border:none; cursor:pointer; color:#9BB5C7; transition:color 0.2s;" onmouseover="this.style.color='#5B7587'" onmouseout="this.style.color='#9BB5C7'">
                        <svg class="eye-open" style="width:1.25rem; height:1.25rem; display:block;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <svg class="eye-closed" style="width:1.25rem; height:1.25rem; display:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12c1.292 4.338 5.31 7.5 10.066 7.5.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
                @if ($errors->has('password'))
                    <p style="margin-top:0.375rem; font-size:0.75rem; color:#EF4444; display:flex; align-items:center; gap:0.25rem;">
                        <svg style="width:0.875rem; height:0.875rem; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                        {{ $errors->first('password') }}
                    </p>
                @endif
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label for="password_confirmation" style="display:block; font-size:0.75rem; font-weight:500; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.75rem; color:#5B7587;">Konfirmasi Password</label>
                <div style="position:relative;">
                    <svg style="position:absolute; left:0; top:50%; transform:translateY(-50%); width:1.25rem; height:1.25rem; color:#9BB5C7;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        style="width:100%; padding:0.75rem 2.5rem 0.75rem 2.25rem; font-size:0.875rem; font-family:'Inter',sans-serif; color:#0C2D3F; background:transparent; border:none; border-bottom:2px solid #E3F1FB; outline:none; transition:border-color 0.3s;"
                        onfocus="this.style.borderBottomColor='#0EA5E9'"
                        onblur="this.style.borderBottomColor='#E3F1FB'"
                        placeholder="Ulangi password">
                    <button type="button" onclick="togglePassword('password_confirmation', this)" style="position:absolute; right:0; top:50%; transform:translateY(-50%); padding:0.375rem; background:none; border:none; cursor:pointer; color:#9BB5C7; transition:color 0.2s;" onmouseover="this.style.color='#5B7587'" onmouseout="this.style.color='#9BB5C7'">
                        <svg class="eye-open" style="width:1.25rem; height:1.25rem; display:block;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <svg class="eye-closed" style="width:1.25rem; height:1.25rem; display:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12c1.292 4.338 5.31 7.5 10.066 7.5.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
                @if ($errors->has('password_confirmation'))
                    <p style="margin-top:0.375rem; font-size:0.75rem; color:#EF4444; display:flex; align-items:center; gap:0.25rem;">
                        <svg style="width:0.875rem; height:0.875rem; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                        {{ $errors->first('password_confirmation') }}
                    </p>
                @endif
            </div>

            {{-- Submit --}}
            <div style="padding-top:0.5rem;">
                <button type="submit"
                    style="position:relative; overflow:hidden; width:100%; padding:0.875rem 1.5rem; font-size:0.875rem; font-weight:600; font-family:'Inter',sans-serif; color:#fff; background:linear-gradient(135deg,#0EA5E9,#0284C7); border:none; border-radius:9999px; cursor:pointer; transition:all 0.3s; box-shadow:0 8px 24px -4px rgba(14,165,233,0.35);"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 32px -4px rgba(14,165,233,0.45)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 24px -4px rgba(14,165,233,0.35)'"
                    onanimationend="">
                    Daftar
                </button>
            </div>
        </form>

        {{-- Footer Link --}}
        <div style="margin-top:2.5rem; text-align:center; font-size:0.875rem; color:#5B7587;">
            Sudah punya akun?
            <a href="{{ route('login') }}" style="font-weight:600; color:#0EA5E9; text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='#0284C7'" onmouseout="this.style.color='#0EA5E9'">
                Masuk sekarang
            </a>
        </div>
    </div>
</div>
@endsection