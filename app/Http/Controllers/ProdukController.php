<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori; // <-- Wajib: Import Model Kategori
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Menampilkan Halaman Kelola Produk (Untuk Owner)
     */
    public function index(Request $request)
    {
        // Eager load kategori untuk menghindari N+1 problem di view
        $query = Produk::latest()->with('kategori'); 
        
        // Logika Search tetap sama
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_produk', 'like', "%$search%")
                  ->orWhere('harga', 'like', "%$search%");
            });
        }

        $produks = $query->paginate(5)->withQueryString();
        $kategoris = Kategori::all(); // <-- Ambil semua kategori untuk dropdown
        
        // Kirim data Produk dan Kategori ke view
        return view('produk.index', compact('produks', 'kategoris'));
    }

    /**
     * Menyimpan Produk Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'id_kategori' => 'required|exists:kategoris,id', // <-- Validasi Kategori
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('produk', 'public');
        }

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'gambar'      => $gambarPath,
            'id_kategori' => $request->id_kategori, // <-- Simpan Kategori
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }
    
    /**
     * Menampilkan Form Edit Produk
     */
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategoris = Kategori::all(); // <-- Ambil semua kategori untuk form
        return view('produk.edit', compact('produk', 'kategoris')); 
    }
    
    /**
     * Menyimpan Perubahan Produk (Update)
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'id_kategori' => 'required|exists:kategoris,id', // <-- Validasi Kategori
        ]);

        $gambarPath = $produk->gambar; 

        if ($request->hasFile('gambar')) {
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $gambarPath = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'id_kategori' => $request->id_kategori, // <-- Update Kategori
            'gambar'      => $gambarPath,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus Produk
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
    
    // Metode show dan create (tidak memiliki view khusus)
    public function show($id) { abort(404); }
    public function create() { abort(404); }
}