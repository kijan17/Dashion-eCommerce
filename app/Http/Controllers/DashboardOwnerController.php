<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardOwnerController extends Controller
{
    /**
     * Dashboard untuk OWNER.
     */
    public function index()
    {
        // 1. Cek Role Owner (Keamanan)
        if (!Auth::check() || Auth::user()->role !== 'owner') {
            // PERBAIKAN: Harus ada tujuannya, misal ke halaman utama ('/')
            return redirect('/')->with('error', 'Akses ditolak!');
        }

        // 2. LOGIKA BARU: REDIRECT KE PRODUK
        // Karena Owner fokusnya mengelola produk, kita tidak perlu menampilkan
        // dashboard statistik. Langsung lempar ke halaman index produk.
        
        return redirect()->route('produk.index')->with('success', 'Selamat Datang Owner! Silakan kelola produk Anda.');
    }
}