@extends('layouts.main')

@section('title', 'Kelola Produk')

@section('content')
<div class="container-fluid py-2">

    <!-- Judul Halaman -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-dark">Kelola Produk</h2>
        
        <!-- Link Cepat ke Kategori -->
        <a href="{{ route('kategori.index') }}" class="btn btn-sm btn-outline-info mt-2">
            <i class="fas fa-tags me-1"></i> Kelola Kategori
        </a>
    </div>

    <!-- BAGIAN 1: FORM INPUT (Card Putih) -->
    <div class="card border-0 shadow-sm mb-5 bg-white" style="border-radius: 20px;">
        <div class="card-body p-4">
            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Baris 1: Nama Produk & Kategori -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="nama_produk" class="form-label text-muted small ms-1">Nama Produk</label>
                        <input type="text" id="nama_produk" name="nama_produk" class="form-control form-control-lg @error('nama_produk') is-invalid @enderror" 
                               placeholder="Nama Produk" required 
                               style="border-radius: 15px; background-color: #fff; border: 1px solid #e0e0e0;">
                        @error('nama_produk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="id_kategori" class="form-label text-muted small ms-1">Kategori</label>
                        <select id="id_kategori" name="id_kategori" class="form-select form-control-lg @error('id_kategori') is-invalid @enderror" required 
                                style="border-radius: 15px; background-color: #fff; border: 1px solid #e0e0e0;">
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('id_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Baris 2: Harga, Stok, Gambar -->
                <div class="row g-3 align-items-end mb-4">
                    <div class="col-md-3">
                        <label for="harga" class="form-label text-muted small ms-1">Harga (Rp)</label>
                        <input type="number" id="harga" name="harga" class="form-control form-control-lg @error('harga') is-invalid @enderror" 
                               placeholder="Harga" required
                               style="border-radius: 15px; background-color: #fff; border: 1px solid #e0e0e0;">
                        @error('harga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="stok" class="form-label text-muted small ms-1">Stok</label>
                        <input type="number" id="stok" name="stok" class="form-control form-control-lg @error('stok') is-invalid @enderror" 
                               placeholder="Stok" required
                               style="border-radius: 15px; background-color: #fff; border: 1px solid #e0e0e0;">
                        @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="gambar" class="form-label text-muted small ms-1">Gambar Produk</label>
                        <input type="file" id="gambar" name="gambar" class="form-control form-control-lg @error('gambar') is-invalid @enderror" 
                               style="border-radius: 15px; border: 1px solid #e0e0e0;">
                        @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <!-- Tombol Tambah Produk BARU -->
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-lg w-100 py-2" 
                                style="border-radius: 15px; 
                                       /* Gradasi Pink-Merah yang Lebih Menonjol */
                                       background: linear-gradient(135deg, #ff80ab 0%, #e91e63 100%); 
                                       border: none; 
                                       color: white; 
                                       font-weight: bold;
                                       /* Bayangan Pink yang Jelas */
                                       box-shadow: 0 8px 20px rgba(233, 30, 99, 0.4);">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Produk
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- BAGIAN 2: TABEL PRODUK -->
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
        <div class="card-body p-4">
            
            <!-- Search Form -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <form action="{{ route('produk.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}" style="border-radius: 15px 0 0 15px;">
                            <button class="btn btn-outline-secondary" type="submit" style="border-radius: 0 15px 15px 0;">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr class="text-center" style="border-bottom: 2px solid #f0f0f0;">
                            <th class="py-3 text-secondary fw-bold" style="width: 5%;">No</th>
                            <th class="py-3 text-secondary fw-bold" style="width: 20%;">Nama</th>
                            <th class="py-3 text-secondary fw-bold" style="width: 15%;">Kategori</th> 
                            <th class="py-3 text-secondary fw-bold" style="width: 15%;">Harga</th>
                            <th class="py-3 text-secondary fw-bold" style="width: 10%;">Stok</th>
                            <th class="py-3 text-secondary fw-bold" style="width: 15%;">Gambar</th>
                            <th class="py-3 text-secondary fw-bold" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produks as $key => $produk)
                        <tr class="text-center" style="border-bottom: 1px solid #f8f9fa;">
                            <td class="text-muted">{{ $produks->firstItem() + $key }}</td>
                            <td class="fw-bold text-dark">{{ $produk->nama_produk }}</td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2" style="background-color: #ffcdd2; color: #b71c1c;">
                                    {{ $produk->kategori->nama_kategori ?? 'Uncategorized' }}
                                </span>
                            </td> 
                            <td class="text-muted">Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
                            <td class="fw-bold">{{ $produk->stok }}</td>
                            <td>
                                @if($produk->gambar)
                                    <div style="width: 60px; height: 70px; margin: 0 auto; overflow: hidden; border-radius: 8px; background-color: #f0f0f0;">
                                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="[Image of Produk]" 
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-sm fw-bold px-3" 
                                       style="background-color: #e0f7fa; color: #006064; border: none; border-radius: 8px;">
                                        Edit
                                    </a>

                                    <form onsubmit="return confirm('Yakin hapus?');" action="{{ route('produk.destroy', $produk->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm fw-bold px-3" 
                                                style="background-color: #fce4ec; color: #c2185b; border: none; border-radius: 8px;">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">Belum ada data produk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-4">
                {{ $produks->links() }}
            </div>

        </div>
    </div>
</div>
@endsection