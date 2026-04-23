<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Tampilkan form registrasi.
     * Jika sudah login, redirect ke katalog.
     */
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('produk.index');
        }

        return view('auth.register');
    }

    /**
     * Proses registrasi user baru.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'string', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            // 'confirmed' → otomatis cocokkan dengan field 'password_confirmation'
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email ini sudah terdaftar. Silakan login.',
            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 8 karakter.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user', // selalu 'user', tidak bisa dipilih dari form
        ]);

        // Trigger event Registered:
        // - Mengirim email verifikasi secara otomatis
        // - Memanfaatkan fitur bawaan Laravel MustVerifyEmail
        event(new Registered($user));

        // Login otomatis setelah register
        Auth::login($user);

        // Arahkan ke halaman notice verifikasi email
        // (karena route 'produk.index' dilindungi middleware 'verified')
        return redirect()->route('verification.notice')
            ->with('status', 'Akun berhasil dibuat! Silakan cek email Anda untuk verifikasi.');
    }
}