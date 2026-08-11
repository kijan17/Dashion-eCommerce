<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk; // Import Model Produk agar bisa mengambil data
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Menampilkan Halaman Depan (Landing Page / Dashboard Pembeli)
     */
    public function index()
    {
        // --- BAGIAN 1: DATA PRODUK (WAJIB UNTUK LANDING PAGE) ---
        // Ambil 8 produk terbaru
        $produkTerbaru = Produk::latest()->take(8)->get();
        
        // Ambil 4 produk rekomendasi secara acak
        $produkRekomendasi = Produk::inRandomOrder()->take(4)->get();

        // --- BAGIAN 2: KIRIM DATA KE VIEW ---
        
        // Kirim semua data produk ke view 'home'
        return view('home', compact('produkTerbaru', 'produkRekomendasi'));
    }
}