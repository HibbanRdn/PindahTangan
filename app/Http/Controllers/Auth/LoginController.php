<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan form login.
     * Jika sudah login, redirect sesuai role.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectAfterLogin();
        }

        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Regenerate session untuk mencegah session fixation attack
            $request->session()->regenerate();

            return $this->redirectAfterLogin();
        }

        // Gagal login: kembalikan ke form dengan pesan error
        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ]);
    }

    /**
     * Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('status', 'Anda berhasil keluar.');
    }

    /**
     * Tentukan redirect setelah login berdasarkan role.
     */
    private function redirectAfterLogin()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // User biasa: cek apakah sudah verifikasi email
        if (! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        // Redirect ke intended URL jika ada (misal: user dicegat middleware
        // saat mau checkout, lalu login — akan dikembalikan ke checkout)
        return redirect()->intended(route('produk.index'));
    }
}