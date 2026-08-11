<?php

namespace App\Http\Controllers;

use App\Models\Hutang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HutangController extends Controller
{
    // 1. HALAMAN KELOLA (Daftar Hutang Belum Lunas)
    public function index()
    {
        $hutangs = Hutang::where('status', '!=', 'Lunas')->latest()->get();
        return view('hutang.index', compact('hutangs'));
    }

    // 2. HALAMAN RIWAYAT (Daftar Hutang Lunas)
    public function riwayat()
    {
        $hutangs = Hutang::where('status', 'Lunas')->latest()->get();
        return view('hutang.riwayat', compact('hutangs'));
    }

    // 3. SIMPAN HUTANG BARU
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string',
            'total_utang' => 'required|numeric|min:1',
        ]);

        Hutang::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'total_utang'    => $request->total_utang,
            'jumlah_dibayar' => 0,
            'sisa_utang'     => $request->total_utang,
            'status'         => 'Belum Lunas',
            'tanggal'        => Carbon::now()->toDateString(),
            'jam'            => Carbon::now()->toTimeString(),
        ]);

        return redirect()->route('hutang.index')->with('success', 'Data hutang berhasil ditambahkan!');
    }

    // 4. BAYAR / CICIL HUTANG
    public function update(Request $request, $id)
    {
        $request->validate([ 'bayar' => 'required|numeric|min:1' ]);

        $hutang = Hutang::findOrFail($id);
        $bayar_sekarang = $request->bayar;
        $total_sudah_dibayar = $hutang->jumlah_dibayar + $bayar_sekarang;

        if ($bayar_sekarang > $hutang->sisa_utang) {
            return back()->with('error', 'Jumlah pembayaran melebihi sisa hutang!');
        }

        $sisa_baru = $hutang->total_utang - $total_sudah_dibayar;
        $status_baru = ($sisa_baru <= 0) ? 'Lunas' : 'Belum Lunas';

        $hutang->update([
            'jumlah_dibayar' => $total_sudah_dibayar,
            'sisa_utang'     => $sisa_baru,
            'status'         => $status_baru,
        ]);

        if ($status_baru == 'Lunas') {
            return redirect()->route('hutang.riwayat')->with('success', 'Hutang Lunas! Data dipindahkan ke Riwayat.');
        }

        return redirect()->route('hutang.index')->with('success', 'Pembayaran berhasil dicatat.');
    }

    // 5. HAPUS DATA
    public function destroy($id)
    {
        Hutang::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}