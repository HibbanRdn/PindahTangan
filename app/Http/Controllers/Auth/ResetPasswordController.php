<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class ResetPasswordController extends Controller
{
    /**
     * Tampilkan form reset password.
     * Token dan email diteruskan dari URL link di email.
     */
    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    /**
     * Proses reset password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)],
        ], [
            'token.required'     => 'Token reset tidak valid.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'password.required'  => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 8 karakter.',
        ]);

        // Password::reset akan:
        // 1. Verifikasi token dari tabel password_reset_tokens
        // 2. Update password user
        // 3. Hapus token dari tabel (single-use)
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                // Trigger event PasswordReset
                // (membatalkan semua sesi aktif user secara opsional)
                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            // Berhasil — redirect ke login dengan pesan sukses
            return redirect()->route('login')
                ->with('status', 'Password Anda berhasil direset. Silakan masuk dengan password baru.');
        }

        // Gagal (token tidak valid / expired, email tidak cocok, dsb)
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}