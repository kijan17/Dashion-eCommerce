<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Menampilkan daftar item di Keranjang.
     */
    public function index()
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Ambil data keranjang milik user yang sedang login
        $keranjangs = Keranjang::where('id_user', Auth::id())
            ->with('produk') // Load relasi produk
            ->get();
            
        $totalHarga = 0;
        $keranjangsToKeep = collect(); 

        foreach ($keranjangs as $item) {
            $produk = $item->produk;
            
            // --- Logika Pembersihan dan Validasi ---
            if ($produk) {
                // 1. Jika jumlah item melebihi stok, koreksi
                if ($item->jumlah > $produk->stok) {
                    $item->jumlah = $produk->stok;
                    $item->save();
                    // Jika stok jadi 0 setelah koreksi, hapus item (opsional)
                    if ($item->jumlah == 0) {
                        $item->delete();
                        continue;
                    }
                }
                
                // 2. Jika produk valid, hitung total
                $totalHarga += $produk->harga * $item->jumlah;
                $keranjangsToKeep->push($item);
            } else {
                // Hapus item keranjang yang produknya hilang (orphaned)
                $item->delete(); 
            }
        }
        // -------------------------------------------------

        return view('keranjang.index', [
            'keranjangs' => $keranjangsToKeep, 
            'totalHarga' => $totalHarga
        ]);
    }

    /**
     * Menyimpan (Menambah) item ke Keranjang.
     */
    public function store(Request $request)
    {
        // Pastikan id_produk yang dikirim ada di tabel produks
        $request->validate(['id_produk' => 'required|exists:produks,id']);
        
        $idProduk = $request->id_produk;
        $idUser = Auth::id();
        $jumlahBeli = 1;
        
        $produk = Produk::findOrFail($idProduk);
        if ($produk->stok < 1) {
            return back()->with('error', 'Maaf, stok produk ini sedang habis.');
        }

        $keranjang = Keranjang::where('id_user', $idUser)
                              ->where('id_produk', $idProduk)
                              ->first();

        if ($keranjang) {
            // Cek jika menambah 1 lagi melebihi stok
            if (($keranjang->jumlah + 1) > $produk->stok) {
                return back()->with('error', 'Tidak bisa menambahkan. Stok hanya tersedia ' . $produk->stok . '.');
            }
            $keranjang->increment('jumlah', $jumlahBeli);
            $message = 'Jumlah produk di keranjang berhasil ditambahkan.';
        } else {
            Keranjang::create([
                'id_user' => $idUser,
                'id_produk' => $idProduk,
                'jumlah' => $jumlahBeli,
            ]);
            $message = 'Produk berhasil ditambahkan ke keranjang.';
        }
        
        return redirect()->route('keranjang.index')->with('success', $message);
    }
    
    /**
     * Mengupdate jumlah item di keranjang.
     */
    public function update(Request $request, $id)
    {
        $keranjang = Keranjang::findOrFail($id);

        $request->validate(['jumlah' => 'required|integer|min:1']);
        
        $produk = $keranjang->produk;
        $jumlahBaru = $request->jumlah;

        if (!$produk) {
             $keranjang->delete();
             return redirect()->route('keranjang.index')->with('error', 'Item telah dihapus karena produk tidak ditemukan.');
        }

        if ($jumlahBaru > $produk->stok) {
            return back()->with('error', 'Stok produk hanya tersedia ' . $produk->stok . '.');
        }

        $keranjang->update(['jumlah' => $jumlahBaru]);

        return back()->with('success', 'Jumlah produk di keranjang berhasil diperbarui.');
    }

    /**
     * Menghapus item dari Keranjang.
     */
    public function destroy($id)
    {
        Keranjang::findOrFail($id)->delete();
        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}