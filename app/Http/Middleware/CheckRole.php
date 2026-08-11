<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Parameter $roles bisa menerima banyak role, misal: 'admin,owner'
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah sudah login (Double check)
        if (!Auth::check()) {
            return redirect('/auth/login');
        }

        // 2. Ambil role user saat ini
        $userRole = Auth::user()->role;

        // 3. Cek apakah role user ada di dalam daftar role yang diizinkan
        // Contoh: jika $roles = ['admin', 'owner'] dan userRole = 'pembeli', maka DITOLAK.
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // 4. Jika role tidak cocok, kembalikan ke halaman sebelumnya atau home
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
    }
}