@extends('layouts.buyer')

@section('title', 'Katalog Produk - Dashion')

@section('content')

<!-- Header Katalog -->
<div class="container mt-4 mb-5">
    <div class="text-center py-5 rounded-4 shadow-sm" style="background: linear-gradient(135deg, #fff0f5 0%, #ffe4e9 100%);">
        @if($selectedKategori)
            <h1 class="fw-bold display-5" style="color: #e91e63;">{{ $selectedKategori->nama_kategori }}</h1>
            <p class="lead text-muted">Semua koleksi terbaru di kategori ini</p>
        @else
            <h1 class="fw-bold display-5" style="color: #e91e63;">Semua Koleksi</h1>
            <p class="lead text-muted">Temukan fashion favoritmu di sini</p>
        @endif
    </div>
</div>

<div class="container">
    <div class="row">
        
        <!-- SIDEBAR FILTER (Kiri) -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm p-3 sticky-top" style="top: 100px; z-index: 1;">
                <h5 class="fw-bold mb-3"><i class="fas fa-filter me-2" style="color: #e91e63;"></i> Filter</h5>
                
                <!-- Form Pencarian (Mempertahankan Filter Kategori) -->
                <form action="{{ route('pembeli.produk') }}" method="GET" class="mb-4">
                    <label class="form-label small text-muted fw-bold">Cari Produk</label>
                    <div class="input-group">
                        <!-- Input hidden untuk mempertahankan filter kategori saat mencari -->
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}"> 
                        <input type="text" name="search" class="form-control" placeholder="Nama baju, tas..." value="{{ request('search') }}">
                        <button class="btn" style="background-color: #e91e63; color: white;" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>

                <!-- Kategori Dinamis -->
                <h6 class="fw-bold small text-muted mb-2">KATEGORI</h6>
                <ul class="list-unstyled">
                    <!-- Tombol Reset Filter Kategori -->
                    <li class="mb-2">
                        <a href="{{ route('pembeli.produk', ['search' => request('search')]) }}" 
                           class="text-decoration-none d-block py-1 px-2 rounded 
                           {{ !request()->filled('kategori') ? 'bg-danger text-white fw-bold' : 'text-secondary hover-bg-light' }}">
                            <i class="fas fa-list me-1"></i> Semua Kategori
                        </a>
                    </li>
                    
                    @foreach($kategoris as $kategori)
                    <li class="mb-2">
                        <a href="{{ route('pembeli.produk', ['kategori' => $kategori->id, 'search' => request('search')]) }}" 
                           class="text-decoration-none d-block py-1 px-2 rounded 
                           {{ request('kategori') == $kategori->id ? 'bg-danger text-white fw-bold' : 'text-secondary hover-bg-light' }}">
                            {{ $kategori->nama_kategori }}
                        </a>
                    </li>
                    @endforeach
                </ul>

                <hr>
                
                <a href="{{ route('pembeli.produk') }}" class="btn btn-outline-secondary w-100 btn-sm">Reset Semua Filter</a>
            </div>
        </div>

        <!-- LIST PRODUK (Kanan) -->
        <div class="col-lg-9">
            
            <!-- Info Hasil Pencarian/Filter -->
            @if(request('search') || request('kategori'))
                <div class="alert alert-light border shadow-sm mb-4">
                    Menampilkan hasil: 
                    @if(request('search'))
                        Pencarian: <strong>"{{ request('search') }}"</strong>
                    @endif
                    @if($selectedKategori)
                        @if(request('search')) dan @endif
                        Kategori: <strong>{{ $selectedKategori->nama_kategori }}</strong>
                    @endif
                    <a href="{{ route('pembeli.produk') }}" class="text-danger ms-3 small fw-bold">Reset</a>
                </div>
            @endif

            <div class="row g-4">
                @forelse($produks as $produk)
                <div class="col-6 col-md-4">
                    <div class="card border-0 shadow-sm h-100 product-card">
                        <!-- Gambar Produk -->
                        <div style="height: 250px; overflow: hidden;" class="rounded-top bg-light position-relative product-img-wrapper">
                            @if($produk->gambar)
                                <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top w-100 h-100 object-fit-cover" alt="{{ $produk->nama_produk }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                    [Image of Placeholder]
                                </div>
                            @endif
                            
                            <!-- Badge Stok/Kategori -->
                            <span class="position-absolute bottom-0 start-0 bg-secondary text-white px-2 py-1 m-2 rounded fw-bold small shadow-sm">
                                {{ $produk->kategori->nama_kategori ?? 'Uncategorized' }}
                            </span>
                        </div>

                        <div class="card-body p-3">
                            <h6 class="card-title fw-bold text-truncate mb-1" title="{{ $produk->nama_produk }}">{{ $produk->nama_produk }}</h6>
                            <p class="card-text fw-bold fs-5 mb-2" style="color: #e91e63;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <small class="text-muted"><i class="fas fa-box me-1"></i> Stok: {{ $produk->stok }}</small>
                                <small class="text-warning"><i class="fas fa-star"></i> 4.8</small>
                            </div>

                            <!-- Tombol Aksi -->
                            @if($produk->stok > 0)
                                @auth
                                    <form action="{{ route('keranjang.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_produk" value="{{ $produk->id }}">
                                        <button type="submit" class="btn w-100 rounded-pill btn-sm fw-bold shadow-sm" style="background-color: #e91e63; color: white;">
                                            <i class="fas fa-cart-plus me-1"></i> + Keranjang
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100 rounded-pill btn-sm fw-bold">Login untuk Membeli</a>
                                @endauth
                            @else
                                <button class="btn btn-secondary w-100 rounded-pill btn-sm fw-bold disabled">Stok Habis</button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-3x mb-3 text-muted opacity-50"></i>
                        <h4 class="mt-3 text-muted">Produk tidak ditemukan</h4>
                        <p class="text-secondary">Coba kata kunci lain atau reset filter.</p>
                        <a href="{{ route('pembeli.produk') }}" class="btn btn-outline-danger rounded-pill mt-2">Lihat Semua Produk</a>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $produks->links() }}
            </div>

        </div>
    </div>
</div>

<style>
    /* Custom CSS untuk halaman produk */
    .hover-bg-light:hover { background-color: #f8f9fa; color: #e91e63 !important; }
    .product-card { transition: 0.3s; border: 1px solid #f0f0f0; }
    .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; border-color: transparent; }
    .product-img-wrapper img { transition: 0.5s; }
    .product-card:hover .product-img-wrapper img { transform: scale(1.05); }
</style>
@endsection