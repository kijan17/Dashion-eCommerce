<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori; // <-- Import Model Kategori

class PembeliController extends Controller
{
    /**
     * Menampilkan Halaman Katalog Produk (Semua Produk)
     * URL: /produk-katalog
     */
    public function index(Request $request)
    {
        // 1. Mulai Query (Produk terkini)
        $query = Produk::latest()->where('stok', '>', 0)->with('kategori'); // Hanya tampilkan yang stoknya ada
        $selectedKategori = null;
        
        // 2. Logika Pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_produk', 'like', "%$search%");
        }

        // 3. Logika FILTER KATEGORI (BARU)
        if ($request->filled('kategori')) {
            $idKategori = $request->kategori;
            $query->where('id_kategori', $idKategori);
            
            // Ambil nama kategori yang terpilih untuk ditampilkan di header
            $selectedKategori = Kategori::find($idKategori); 
        }

        // 4. Pagination (12 produk per halaman)
        $produks = $query->paginate(3)->withQueryString();
        
        // 5. Ambil semua Kategori untuk Sidebar Filter
        $kategoris = Kategori::all();

        // 6. Kirim data ke view
        return view('pembeli.produk', compact('produks', 'kategoris', 'selectedKategori'));
    }
}