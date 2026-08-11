@extends('layouts.main')

@section('title', 'Kelola Kategori')

@section('content')
<div class="container-fluid py-4">

    <!-- Judul Halaman -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Kelola Kategori Produk</h1>
    </div>

    <!-- BAGIAN 1: Pesan Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <h4 class="alert-heading small">Gagal!</h4>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- BAGIAN 2: TABEL KATEGORI -->
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center" style="border-radius: 15px 15px 0 0;">
            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-tags me-2 text-primary"></i> Daftar Kategori</h5>
            
            <!-- Tombol Tambah Kategori -->
            <button type="button" class="btn btn-primary fw-bold px-4 py-2" 
                    data-bs-toggle="modal" data-bs-target="#modalTambahKategori" style="border-radius: 10px;">
                <i class="fas fa-plus me-1"></i> Tambah Baru
            </button>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 ps-4" style="width: 5%;">No</th>
                            <th class="py-3 text-start ps-5" style="width: 65%;">Nama Kategori</th>
                            <th class="py-3" style="width: 15%;">Jumlah Produk</th>
                            <th class="py-3" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $key => $kategori)
                        <tr style="border-bottom: 1px solid #f8f9fa;">
                            <td class="text-muted ps-4">{{ $kategoris->firstItem() + $key }}</td>
                            <td class="fw-bold text-start ps-5 text-dark">{{ $kategori->nama_kategori }}</td>
                            <td>
                                <!-- Hitung Jumlah Produk yang terkait -->
                                <span class="badge bg-secondary rounded-pill px-3 py-2">
                                    {{ $kategori->produks_count }} <!-- Ganti $kategori->produks->count() menjadi $kategori->produks_count -->
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Tombol Edit -->
                                    <button type="button" class="btn btn-sm fw-bold px-3" 
                                            style="background-color: #e0f7fa; color: #006064; border: none; border-radius: 8px;"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEditKategori{{ $kategori->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form onsubmit="return confirm('Menghapus kategori akan membuat produk terkait menjadi Uncategorized. Lanjutkan?');" 
                                          action="{{ route('kategori.destroy', $kategori->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm fw-bold px-3" 
                                                style="background-color: #fce4ec; color: #c2185b; border: none; border-radius: 8px;">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- MODAL EDIT KATEGORI -->
                        <div class="modal fade" id="modalEditKategori{{ $kategori->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title fw-bold ms-2">Edit Kategori</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-body text-start p-4">
                                            <label class="form-label fw-bold text-muted">Nama Kategori</label>
                                            <input type="text" name="nama_kategori" class="form-control form-control-lg" 
                                                   value="{{ $kategori->nama_kategori }}" required
                                                   style="border-radius: 10px; background-color: #f8f9fa;">
                                        </div>
                                        <div class="modal-footer border-0 pt-0 pb-4 pe-4">
                                            <button type="button" class="btn btn-light text-muted fw-bold" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                                            <button type="submit" class="btn btn-primary fw-bold px-4" style="border-radius: 8px;">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-3x mb-3 opacity-50"></i>
                                <p class="mb-0">Belum ada kategori yang ditambahkan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end p-3">
                {{ $kategoris->links() }}
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH KATEGORI BARU -->
<div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 15px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold ms-2">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body text-start p-4">
                    <label class="form-label fw-bold text-muted">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control form-control-lg" 
                           placeholder="Contoh: Pakaian, Sepatu, Aksesori" required
                           style="border-radius: 10px; background-color: #f8f9fa;">
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 pe-4">
                    <button type="button" class="btn btn-light text-muted fw-bold" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4" style="border-radius: 8px;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection