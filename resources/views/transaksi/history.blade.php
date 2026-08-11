@extends('layouts.buyer')

@section('title', 'Riwayat Belanja')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4" style="color: #e91e63;"><i class="fas fa-history me-2"></i> Riwayat Belanja Anda</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 ps-4">ID Transaksi</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3">Metode Bayar</th>
                            <th class="py-3 text-end">Total Bayar</th>
                            <th class="py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $transaksi)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">#{{ $transaksi->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}</td>
                            <td>{{ $transaksi->metode }}</td>
                            <td class="text-end fw-bold fs-5" style="color: #e91e63;">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="badge bg-success rounded-pill px-3 py-2">Selesai</span> <!-- Dummy Status -->
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-3x mb-3 opacity-50"></i>
                                <p class="mb-0">Anda belum memiliki riwayat transaksi.</p>
                                <a href="{{ route('pembeli.produk') }}" class="btn btn-sm btn-outline-danger mt-3">Mulai Belanja</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="p-3">
                 {{ $transaksis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection