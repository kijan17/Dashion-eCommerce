@extends('layouts.buyer')

@section('title', 'Dashion - Home')

@section('content')

<!-- HERO SECTION -->
<div class="container mt-4">
    <div id="heroCarousel" class="carousel slide rounded-4 overflow-hidden shadow" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" style="height: 450px;">
                <img src="https://i.pinimg.com/1200x/2e/5f/ba/2e5fbaf288fb180df4796d48975178a0.jpg" class="d-block w-100 h-100 object-fit-cover" alt="Fashion 1">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-4 mb-4">
                    <h2 class="fw-bold display-5">Koleksi Terbaru 2025</h2>
                    <p class="fs-5">Tampil modis dengan gaya terkini.</p>
                    <a href="{{ route('pembeli.produk') }}" class="btn btn-light fw-bold text-danger btn-lg mt-2">Belanja Sekarang</a>
                </div>
            </div>
            <!-- Slide Tambahan Bisa Di sini -->
        </div>
    </div>
</div>

<!-- SECTION KATEGORI -->
<div class="container mt-5 mb-5 pb-4">
    <h3 class="text-center fw-bold mb-5" style="color: #333;">Kategori Pilihan</h3>
    <div class="row justify-content-center g-4">
        <div class="col-6 col-md-3 text-center">
            <div class="p-4 bg-white rounded-circle shadow-sm mx-auto mb-3 d-flex align-items-center justify-content-center category-icon-box" style="width: 100px; height: 100px; transition: 0.3s;">
                <i class="fas fa-tshirt fa-3x text-danger"></i>
            </div>
            <p class="fw-bold fs-5">Pakaian</p>
        </div>
        <div class="col-6 col-md-3 text-center">
            <div class="p-4 bg-white rounded-circle shadow-sm mx-auto mb-3 d-flex align-items-center justify-content-center category-icon-box" style="width: 100px; height: 100px; transition: 0.3s;">
                <i class="fas fa-shopping-bag fa-3x text-danger"></i>
            </div>
            <p class="fw-bold fs-5">Tas</p>
        </div>
        <div class="col-6 col-md-3 text-center">
            <div class="p-4 bg-white rounded-circle shadow-sm mx-auto mb-3 d-flex align-items-center justify-content-center category-icon-box" style="width: 100px; height: 100px; transition: 0.3s;">
                <i class="fas fa-shoe-prints fa-3x text-danger"></i>
            </div>
            <p class="fw-bold fs-5">Sepatu</p>
        </div>
        <div class="col-6 col-md-3 text-center">
            <div class="p-4 bg-white rounded-circle shadow-sm mx-auto mb-3 d-flex align-items-center justify-content-center category-icon-box" style="width: 100px; height: 100px; transition: 0.3s;">
                <i class="fas fa-gem fa-3x text-danger"></i>
            </div>
            <p class="fw-bold fs-5">Aksesori</p>
        </div>
    </div>
</div>

<!-- PRODUK REKOMENDASI (DINAMIS - HANYA MUNCUL JIKA PEMBELI LOGIN) -->
@auth
    @if(Auth::user()->role == 'pembeli')
    <div class="container mt-5 pt-4">
        
        <!-- Judul Dinamis -->
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2" style="border-color: #e91e63 !important;">
            <h3 class="fw-bold m-0" style="color: #333; border-left: 5px solid #e91e63; padding-left: 15px;">Pilihan Khusus Untuk Anda, {{ Auth::user()->username }}</h3>
            <a href="{{ route('pembeli.produk') }}" class="btn btn-outline-danger rounded-pill px-4 fw-bold">Lihat Semua</a>
        </div>

        <div class="row g-4">
            {{-- Pastikan HomeController mengirim variabel $produkRekomendasi --}}
            @if(isset($produkRekomendasi))
                @foreach($produkRekomendasi as $produk)
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div style="height: 280px; overflow: hidden;" class="rounded-top bg-light position-relative">
                            @if($produk->gambar)
                                <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top w-100 h-100 object-fit-cover" alt="{{ $produk->nama_produk }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                    [Image of placeholder]
                                </div>
                            @endif
                        </div>
                        <div class="card-body text-center p-3">
                            <h6 class="card-title fw-bold text-truncate mb-1">{{ $produk->nama_produk }}</h6>
                            <p class="card-text text-danger fw-bold fs-5 mb-2">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                            <a href="#" class="btn btn-danger w-100 rounded-pill btn-sm fw-bold"><i class="fas fa-shopping-bag me-1"></i> Beli Sekarang</a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                 <div class="col-12 text-center py-3">
                    <p class="text-muted">Belum ada rekomendasi produk saat ini.</p>
                </div>
            @endif
        </div>
    </div>
    @endif
@endauth

@endsection