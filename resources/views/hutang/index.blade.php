@extends('layouts.main')

@section('title', 'Kelola Hutang')

@section('content')
<div class="container-fluid py-4">

    <!-- Header Halaman -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Kelola Hutang Pelanggan</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('hutang.riwayat') }}" class="btn btn-sm btn-outline-success">
                <i class="fas fa-history me-1"></i> Lihat Riwayat Lunas
            </a>
        </div>
    </div>

    <!-- Pesan Sukses/Error -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- BAGIAN 1: FORM CATAT HUTANG BARU -->
    <div class="card border-0 shadow-sm mb-4 bg-white" style="border-radius: 15px;">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-danger"><i class="fas fa-user-plus me-2"></i> Catat Hutang Baru</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('hutang.store') }}" method="POST">
                @csrf
                <div class="row g-3 align-items-end">
                    <!-- Nama Pelanggan -->
                    <div class="col-md-5">
                        <label class="form-label text-muted small ms-1">Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan" class="form-control form-control-lg" placeholder="Contoh: Ibu Ani" required style="border-radius: 10px;">
                    </div>
                    
                    <!-- Total Hutang -->
                    <div class="col-md-4">
                        <label class="form-label text-muted small ms-1">Total Hutang (Rp)</label>
                        <input type="number" name="total_utang" class="form-control form-control-lg" placeholder="0" required style="border-radius: 10px;">
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="col-md-3">
                        <button type="submit" class="btn text-white fw-bold px-4 py-2 w-100" 
                                style="background: linear-gradient(90deg, #ff8a65, #ef5350); border: none; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            Simpan Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- BAGIAN 2: TABEL DAFTAR HUTANG (BELUM LUNAS) -->
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-list-alt me-2"></i> Daftar Belum Lunas</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3">No</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3 text-start">Pelanggan</th>
                            <th class="py-3">Total Hutang</th>
                            <th class="py-3">Sudah Dibayar</th>
                            <th class="py-3 text-danger">Sisa Hutang</th>
                            <th class="py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hutangs as $h)
                        <tr>
                            <td class="text-muted">{{ $loop->iteration }}</td>
                            <td>
                                {{ $h->tanggal }} <br> 
                                <small class="text-muted">{{ $h->jam }}</small>
                            </td>
                            <td class="fw-bold text-start text-dark">{{ $h->nama_pelanggan }}</td>
                            <td>Rp{{ number_format($h->total_utang, 0, ',', '.') }}</td>
                            <td class="text-success">Rp{{ number_format($h->jumlah_dibayar, 0, ',', '.') }}</td>
                            <td class="fw-bold text-danger">Rp{{ number_format($h->sisa_utang, 0, ',', '.') }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Tombol Bayar (Memicu Modal) -->
                                    <button type="button" class="btn btn-sm btn-primary px-3 fw-bold" 
                                            style="border-radius: 8px;" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalBayar{{ $h->id }}">
                                        Bayar
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form onsubmit="return confirm('Hapus data hutang ini?');" action="{{ route('hutang.destroy', $h->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger px-2" style="border-radius: 8px;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- MODAL PEMBAYARAN (Setiap baris punya modal sendiri) -->
                                <div class="modal fade" id="modalBayar{{ $h->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-light">
                                                <h5 class="modal-title fw-bold">Pembayaran: {{ $h->nama_pelanggan }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('hutang.update', $h->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body text-start p-4">
                                                    <div class="alert alert-info mb-3">
                                                        Sisa Hutang: <strong>Rp{{ number_format($h->sisa_utang, 0, ',', '.') }}</strong>
                                                    </div>
                                                    
                                                    <label class="form-label fw-bold">Masukkan Jumlah Bayar (Rp)</label>
                                                    <input type="number" name="bayar" class="form-control form-control-lg" 
                                                           placeholder="0" required min="1" max="{{ $h->sisa_utang }}">
                                                    <small class="text-muted">Maksimal: {{ $h->sisa_utang }}</small>
                                                </div>
                                                <div class="modal-footer bg-light border-0">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success fw-bold px-4">Konfirmasi Bayar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Modal -->

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-check-circle fa-3x mb-3 text-success opacity-25"></i>
                                <p class="mb-0">Tidak ada data hutang aktif.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection