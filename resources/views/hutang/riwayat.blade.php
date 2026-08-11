@extends('layouts.main')

@section('title', 'Riwayat Lunas')

@section('content')
<div class="container-fluid py-4">

    <!-- Header Halaman -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2">Riwayat Hutang Lunas</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('hutang.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Kelola Hutang
            </a>
        </div>
    </div>

    <!-- Pesan Sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- TABEL RIWAYAT LUNAS -->
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-success text-white py-3">
            <h5 class="mb-0 fw-bold"><i class="fas fa-history me-2"></i> Arsip Data Lunas</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3">No</th>
                            <th class="py-3">Tanggal Lunas</th> <!-- Sebaiknya tanggal update terakhir -->
                            <th class="py-3 text-start">Pelanggan</th>
                            <th class="py-3">Total Nominal</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hutangs as $h)
                        <tr>
                            <td class="text-muted">{{ $loop->iteration }}</td>
                            <td>{{ $h->updated_at->format('d M Y') }}</td>
                            <td class="fw-bold text-start text-dark">{{ $h->nama_pelanggan }}</td>
                            <td>Rp{{ number_format($h->total_utang, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-success rounded-pill px-3 py-2">LUNAS</span>
                            </td>
                            <td>
                                <form onsubmit="return confirm('Hapus riwayat ini permanen?');" action="{{ route('hutang.destroy', $h->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger px-3" style="border-radius: 8px;">
                                        <i class="fas fa-trash-alt me-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-muted py-5">Belum ada riwayat lunas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection