@extends('layouts.buyer')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4" style="color: #e91e63;"><i class="fas fa-shopping-cart me-2"></i> Keranjang Belanja Anda</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        
        <!-- Kolom Kiri: Daftar Item Keranjang -->
        <div class="col-lg-8 mb-4">
            @forelse($keranjangs as $item)
            <div class="card shadow-sm mb-3 border-0" style="border-radius: 15px;">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <!-- Gambar & Nama Produk -->
                        <div class="col-md-6 d-flex align-items-center">
                            <div style="width: 70px; height: 70px; overflow: hidden; border-radius: 10px; background-color: #f8f9fa;">
                                @if($item->produk->gambar)
                                    <img src="{{ asset('storage/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama_produk }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="text-center pt-3 text-muted">No Image</div>
                                @endif
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 fw-bold">{{ $item->produk->nama_produk }}</h6>
                                <small class="text-muted">Stok tersedia: {{ $item->produk->stok }}</small>
                            </div>
                        </div>

                        <!-- Harga -->
                        <div class="col-md-2 text-center">
                            <small class="text-muted d-block">Harga</small>
                            <p class="mb-0 fw-bold">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</p>
                        </div>
                        
                        <!-- Jumlah -->
                        <div class="col-md-2 text-center">
                            <small class="text-muted d-block">Jumlah</small>
                            <form action="{{ route('keranjang.update', $item->id) }}" method="POST" class="d-flex justify-content-center">
                                @csrf
                                @method('PUT')
                                <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1" max="{{ $item->produk->stok }}" class="form-control form-control-sm text-center" style="width: 60px;" onchange="this.form.submit()">
                            </form>
                        </div>
                        
                        <!-- Aksi -->
                        <div class="col-md-2 text-center">
                            <form action="{{ route('keranjang.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus item ini dari keranjang?');">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <div class="card shadow-sm border-0 py-5 text-center" style="border-radius: 15px;">
                    <i class="fas fa-box-open fa-4x mb-3 text-muted opacity-50"></i>
                    <h4 class="text-muted">Keranjang Anda Kosong</h4>
                    <p class="text-secondary">Yuk, mulai belanja di halaman produk!</p>
                    <a href="{{ route('pembeli.produk') }}" class="btn btn-danger mt-3" style="width: 200px; margin: 0 auto;">
                        <i class="fas fa-shopping-bag me-1"></i> Mulai Belanja
                    </a>
                </div>
            @endforelse

        </div>

        <!-- Kolom Kanan: Ringkasan Checkout -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 100px; border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 border-bottom pb-2">Ringkasan Pesanan</h5>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Harga ({{ count($keranjangs) }} item)</span>
                        <span class="fw-bold">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-flex justify-content-between fw-bold fs-5 mt-4 pt-2 border-top">
                        <span>Grand Total</span>
                        <span style="color: #e91e63;">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('transaksi.create') }}" class="btn btn-danger w-100 mt-4 py-2 fw-bold" 
                       style="border-radius: 10px;"
                       @if(count($keranjangs) == 0) disabled @endif>
                        <i class="fas fa-money-check-alt me-1"></i> Lanjutkan ke Checkout
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection