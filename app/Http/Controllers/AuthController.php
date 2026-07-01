<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Member;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->status !== 'active') {
            Auth::logout();
            return back()->withErrors(['email' => 'Akun anda tidak aktif.']);
        }

        LoginHistory::create([
            'user_id'    => $user->id,
            'ip_address' => $request->ip(),
            'device'     => $request->header('User-Agent'),
            'browser'    => $request->header('Sec-Ch-Ua') ?? 'unknown',
            'platform'   => $request->header('Sec-Ch-Ua-Platform') ?? 'unknown',
            'login_at'   => now(),
        ]);

        return $this->redirectByRole($user);
    }

    /**
     * Tampilkan form register.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses register (default role: anggota/member).
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:150'],
            'email'    => ['required', 'string', 'email', 'max:150', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'role_id'  => config('library.default_role_id', 3),
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'status'   => 'active',
        ]);

        Member::create([
            'user_id'      => $user->id,
            'member_code'  => 'MB-' . strtoupper(Str::random(8)),
            'join_date'    => now(),
            'expired_date' => now()->addYear(),
            'status'       => 'active',
        ]);

        event(new \Illuminate\Auth\Events\Registered($user));

        Auth::login($user);

        return redirect()->route('login')->with('success', 'Registrasi berhasil.');
    }

    /**
     * Logout.
     */
    public function logout(Request $request)
    {
        $userId = Auth::id();

        LoginHistory::where('user_id', $userId)
            ->whereNull('logout_at')
            ->latest('login_at')
            ->first()?->update(['logout_at' => now()]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Form lupa password.
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim link reset password.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Form reset password.
     */
    public function showResetPassword(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Proses reset password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Verifikasi email.
     */
    public function verifyEmail(Request $request)
    {
        $request->fulfill();

        return redirect()->route('dashboard')->with('success', 'Email berhasil diverifikasi.');
    }

    /**
     * Kirim ulang link verifikasi email.
     */
    public function resendVerification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Link verifikasi telah dikirim.');
    }

    private function redirectByRole(User $user)
    {
        return match ($user->role?->name) {
            'admin'    => redirect()->route('admin.dashboard'),
            'petugas'  => redirect()->route('petugas.dashboard'),
            default    => redirect()->route('member.dashboard'),
        };
    }
}
