<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan form lupa password.
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim link reset password ke email user.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        // Password::sendResetLink akan:
        // 1. Cek apakah email terdaftar di tabel users
        // 2. Generate token dan simpan ke tabel password_reset_tokens
        // 3. Kirim email dengan link reset ke user
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            // Berhasil — tampilkan pesan sukses
            // Pesan dibuat ambigu secara sengaja (tidak membedakan
            // "email terdaftar" vs "email tidak terdaftar") untuk
            // mencegah email enumeration attack
            return back()->with('status', __($status));
        }

        // Gagal (email tidak ditemukan, throttle, dsb)
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}