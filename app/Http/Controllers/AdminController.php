<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;       // Import Model User
use App\Models\Transaksi;  // Import Model Transaksi
use App\Models\Produk;     // Import Model Produk (PENTING untuk statistik)

class AdminController extends Controller
{
    /**
     * Menampilkan Dashboard Admin.
     * Halaman ini berisi statistik toko, daftar pembeli, dan riwayat transaksi.
     */
    public function index()
    {
        // 1. Cek Keamanan (Pastikan hanya Admin yang boleh masuk)
        if (!Auth::check() || Auth::user()->role !== 'admin') {
             return redirect('/')->with('error', 'Anda bukan Admin!');
        }

        // --- BAGIAN 1: MENGHITUNG STATISTIK (Untuk Kartu Warna-Warni) ---
        
        // Menghitung total semua produk yang dijual
        $totalProduk = Produk::count();

        // Menghitung produk yang stoknya kurang dari 5 (Perlu restock)
        $stokMenipis = Produk::where('stok', '<', 5)->count();

        // Menghitung total user yang mendaftar sebagai 'pembeli'
        $totalPembeli = User::where('role', 'pembeli')->count();

        // Menghitung total transaksi yang pernah terjadi
        // (Jika tabel transaksi masih kosong, ini akan bernilai 0, jadi aman)
        $totalTransaksi = Transaksi::count();


        // --- BAGIAN 2: MENGAMBIL DATA UNTUK TABEL ---

        // Mengambil semua data transaksi, diurutkan dari yang terbaru
        $transaksis = Transaksi::latest()->get(); 

        // Mengambil semua data pembeli, diurutkan dari yang terbaru
        $pembelis = User::where('role', 'pembeli')->latest()->get();


        // --- BAGIAN 3: KIRIM SEMUA DATA KE VIEW ---
        return view('admin.dashboard', compact(
            'totalProduk',
            'stokMenipis',
            'totalPembeli',
            'totalTransaksi',
            'transaksis',
            'pembelis'
        ));
    }
}