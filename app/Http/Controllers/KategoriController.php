<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar Kategori (Index)
     */
    public function index()
    {
        // Ambil semua kategori terbaru dengan pagination dan hitung jumlah produk terkait
        $kategoris = Kategori::latest()->withCount('produks')->paginate(10);
        
        // Pastikan view kategori.index sudah ada (sudah kita buat sebelumnya)
        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Menyimpan Kategori baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
        ]);

        Kategori::create(['nama_kategori' => $request->nama_kategori]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Mengupdate Kategori
     */
    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->id,
        ]);

        $kategori->update(['nama_kategori' => $request->nama_kategori]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Menghapus Kategori
     */
    public function destroy($id)
    {
        Kategori::findOrFail($id)->delete();
        
        // Produk terkait otomatis menjadi uncategorized (id_kategori = null)
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}