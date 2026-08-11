<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Untuk transaksi database
use Carbon\Carbon;

class TransaksiController extends Controller
{
    /**
     * Menampilkan Form Checkout (Langkah Terakhir sebelum Bayar).
     * Route: transaksi/create
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil item keranjang milik user yang sedang login
        $keranjangs = Keranjang::where('id_user', Auth::id())
            ->with('produk')
            ->get();
        
        // --- LOGIKA PENTING: VALIDASI STOK DAN CLEANUP ITEM ---
        $totalHarga = 0;
        $keranjangsToKeep = collect(); // Koleksi untuk item yang valid

        foreach ($keranjangs as $item) {
            $produk = $item->produk;
            
            // 1. Cek jika produk hilang atau stok nol
            if (!$produk || $produk->stok == 0) {
                $item->delete(); // Hapus item keranjang yang bermasalah
                continue; 
            }
            
            // 2. Cek jika jumlah di keranjang melebihi stok yang tersisa
            if ($item->jumlah > $produk->stok) {
                // Turunkan jumlah item ke batas stok
                $item->jumlah = $produk->stok;
                $item->save();
            }
            
            $totalHarga += $produk->harga * $item->jumlah;
            $keranjangsToKeep->push($item);
        }
        // ---------------------------------------------------

        // Cek jika setelah cleanup keranjang kosong
        if ($keranjangsToKeep->isEmpty()) {
             return redirect()->route('pembeli.produk')->with('error', 'Keranjang Anda kosong setelah validasi stok. Silakan tambahkan produk lain.');
        }

        // Kirim hanya item yang valid
        return view('transaksi.create', [
            'keranjangs' => $keranjangsToKeep, 
            'totalHarga' => $totalHarga
        ]);
    }

    /**
     * Memproses dan Menyimpan Transaksi ke Database (Checkout).
     * Route: transaksi/store
     */
    public function store(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|string',
        ]);

        $idUser = Auth::id();
        $keranjangs = Keranjang::where('id_user', $idUser)->with('produk')->get();
        
        if ($keranjangs->isEmpty()) {
            return redirect()->route('pembeli.produk')->with('error', 'Keranjang kosong, tidak bisa checkout.');
        }

        // --- Mulai Transaksi Database (Atomic Operation) ---
        DB::beginTransaction();

        try {
            $totalBayar = 0;
            $itemsForDetail = [];

            // 1. Validasi Stok Ulang & Hitung Total
            foreach ($keranjangs as $item) {
                $produk = $item->produk;
                
                if (!$produk || $produk->stok < $item->jumlah) {
                    DB::rollBack();
                    return redirect()->route('keranjang.index')->with('error', "Stok {$produk->nama_produk} tidak mencukupi atau produk telah dihapus.");
                }
                
                $subtotal = $produk->harga * $item->jumlah;
                $totalBayar += $subtotal;

                $itemsForDetail[] = [
                    'id_produk' => $item->id_produk,
                    'jumlah' => $item->jumlah,
                    'harga' => $produk->harga, // Harga saat ini
                    'subtotal' => $subtotal,
                ];
            }

            // 2. Buat Record Transaksi Utama
            $transaksi = Transaksi::create([
                'id_user' => $idUser,
                'total' => $totalBayar,
                'metode' => $request->metode_pembayaran,
                'tanggal' => Carbon::now()->toDateString(),
            ]);

            // 3. Simpan Detail Transaksi dan Update Stok
            foreach ($itemsForDetail as $item) {
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id,
                    'id_produk' => $item['id_produk'],
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['subtotal'],
                ]);

                Produk::where('id', $item['id_produk'])->decrement('stok', $item['jumlah']);
            }

            // 4. Bersihkan Keranjang
            Keranjang::where('id_user', $idUser)->delete();

            DB::commit(); // Transaksi berhasil, simpan semua perubahan

            return redirect()->route('transaksi.history')->with('success', 'Checkout berhasil! Pesanan Anda sedang diproses.');

        } catch (\Exception $e) {
            DB::rollBack(); // Jika ada error, batalkan semua perubahan
            return back()->with('error', 'Checkout gagal. Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan Riwayat Transaksi (Untuk Transaksi History)
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil semua transaksi milik user yang sedang login, diurutkan dari terbaru
        $transaksis = Transaksi::where('id_user', Auth::id())
            ->latest()
            ->paginate(10); 

        return view('transaksi.history', compact('transaksis'));
    }
}