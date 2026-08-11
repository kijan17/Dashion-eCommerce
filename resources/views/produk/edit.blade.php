@extends('layouts.main')

@section('title', 'Edit Produk')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark">Edit Produk</h5>
                </div>
                <div class="card-body p-4">
                    <!-- Form akan mengirimkan request PUT ke route produk.update -->
                    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') 

                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                        </div>
                        
                        <!-- DROP DOWN KATEGORI BARU -->
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="id_kategori" class="form-select" required>
                                <option value="" disabled>Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" 
                                            {{ old('id_kategori', $produk->id_kategori) == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- END DROP DOWN KATEGORI -->

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Harga (Rp)</label>
                                <input type="number" name="harga" class="form-control" value="{{ old('harga', $produk->harga) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Stok</label>
                                <input type="number" name="stok" class="form-control" value="{{ old('stok', $produk->stok) }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Ganti Gambar (Opsional)</label>
                            @if($produk->gambar)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="[Gambar Produk Saat Ini]" width="100" class="rounded border">
                                    <small class="text-muted d-block">Gambar saat ini</small>
                                </div>
                            @endif
                            <input type="file" name="gambar" class="form-control">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Update Produk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection