@extends('layouts.main')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid py-4">
    
    <!-- Header Dashboard -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard Admin</h1>
    </div>

    <!-- Sambutan -->
    <div class="alert alert-primary d-flex align-items-center shadow-sm" role="alert">
        <i class="fas fa-user-shield me-2 fa-lg"></i>
        <div>
            Selamat Datang, Admin <strong>{{ Auth::user()->username }}</strong>! Anda memiliki akses penuh untuk memantau aktivitas toko.
        </div>
    </div>

    <!-- --- BAGIAN 1: KARTU STATISTIK --- -->
    <div class="row">
        <!-- Total Pembeli -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pembeli</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPembeli }} Akun</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300 text-primary opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Transaksi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTransaksi }} Pesanan</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300 text-success opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Produk -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Produk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProduk }} Item</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300 text-info opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stok Menipis -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Stok Menipis</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stokMenipis }} Item</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300 text-danger opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- --- BAGIAN 2: TABEL DATA --- -->
    <div class="row mt-4">
        
        <!-- Tabel Daftar Pembeli -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-users me-1"></i> Daftar Pembeli Terbaru</h6>
                    <label class="form-label small text-muted fw-bold">Cari Pembeli</label>
                    <div class="input-group">
                        <!-- Input hidden untuk mempertahankan filter kategori saat mencari -->
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}"> 
                        <input type="text" name="search" class="form-control" placeholder= value="{{ request('search') }}">
                    </div>
                </form>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Bergabung</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pembelis as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle d-flex justify-content-center align-items-center me-2" style="width:30px; height:30px;">
                                                <i class="fas fa-user text-secondary"></i>
                                            </div>
                                            {{ $user->username }}
                                        </div>
                                    </td>
                                    <td><span class="badge bg-info text-dark">{{ $user->role }}</span></td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Belum ada pembeli yang mendaftar.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat Transaksi -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white">
                    <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-shopping-cart me-1"></i> Transaksi Masuk</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Total</th>
                                    <th>Metode</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $transaksi)
                                <tr>
                                    <td>#{{ $transaksi->id }}</td>
                                    <td class="fw-bold text-success">Rp {{ number_format($transaksi->total) }}</td>
                                    <td><span class="badge bg-secondary">{{ $transaksi->metode }}</span></td>
                                    <td>{{ $transaksi->created_at ? $transaksi->created_at->format('d M Y') : '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Belum ada transaksi masuk.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection