@extends('layouts.buyer')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-5" style="color: #e91e63;"><i class="fas fa-money-check-alt me-2"></i> Konfirmasi & Pembayaran</h2>

    <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf
        <div class="row">
            
            <!-- Kolom Kiri: Detail Pesanan & Pembayaran -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm mb-4 border-0" style="border-radius: 15px;">
                    <div class="card-header bg-white py-3 border-bottom-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="fw-bold mb-0">1. Detail Pesanan</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-borderless align-middle mb-0">
                                <thead class="border-bottom">
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-end">Harga Satuan</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($keranjangs as $item)
                                    <tr>
                                        <td>{{ $item->produk->nama_produk }}</td>
                                        <td class="text-center">{{ $item->jumlah }}</td>
                                        <td class="text-end">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                                        <td class="text-end fw-bold">Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Metode Pembayaran -->
                <div class="card shadow-sm mb-4 border-0" style="border-radius: 15px;">
                    <div class="card-header bg-white py-3 border-bottom-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="fw-bold mb-0">2. Pilih Metode Pembayaran</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-check mb-3 p-3 border rounded-3 bg-light">
                            <input class="form-check-input" type="radio" name="metode_pembayaran" id="metode1" value="Transfer Bank" required>
                            <label class="form-check-label fw-bold" for="metode1">
                                <i class="fas fa-university me-2 text-primary"></i> Transfer Bank (BCA / Mandiri)
                            </label>
                        </div>
                        <div class="form-check mb-3 p-3 border rounded-3 bg-light">
                            <input class="form-check-input" type="radio" name="metode_pembayaran" id="metode2" value="COD" required>
                            <label class="form-check-label fw-bold" for="metode2">
                                <i class="fas fa-truck me-2 text-success"></i> Cash On Delivery (COD)
                            </label>
                        </div>
                        <!-- ... Bisa tambah metode lain ... -->
                        @error('metode_pembayaran')
                            <small class="text-danger d-block mt-2">Pilih salah satu metode pembayaran.</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Ringkasan & Tombol Bayar -->
            <div class="col-lg-4">
                <div class="card shadow-lg border-0 sticky-top" style="top: 100px; border-radius: 15px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 border-bottom pb-2">Ringkasan Pembayaran</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal Produk</span>
                            <span class="fw-bold">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted">Biaya Pengiriman</span>
                            <span class="fw-bold text-success">Gratis</span> <!-- Dummy -->
                        </div>

                        <div class="d-flex justify-content-between fw-bold fs-4 mt-3 pt-3 border-top">
                            <span>TOTAL BAYAR</span>
                            <span style="color: #e91e63;">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" class="btn btn-danger w-100 mt-4 py-3 fw-bold fs-5" 
                           style="border-radius: 15px;">
                            <i class="fas fa-lock me-1"></i> Proses Pembayaran
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection