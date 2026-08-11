<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIsLogin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user SUDAH login
        if (Auth::check()) {
            // Jika sudah, boleh lanjut
            return $next($request);
        }

        // Jika BELUM login, tendang ke halaman login dengan pesan error
        return redirect('/auth/login')->with('error', 'Kamu harus login terlebih dahulu!');
    }
}