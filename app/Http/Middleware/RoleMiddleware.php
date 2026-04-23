<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Cek apakah user memiliki role yang diperlukan.
     *
     * Penggunaan di routes/web.php:
     *   ->middleware('role:admin')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Belum login sama sekali
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        // Sudah login tapi role tidak sesuai
        if (Auth::user()->role !== $role) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}