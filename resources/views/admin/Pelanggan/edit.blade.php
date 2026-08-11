@extends('layouts.admin.app')

@section('content')
        <!-- Start Main Content --> 
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
            <div class="d-block mb-4 mb-md-0">
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                    <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                        <li class="breadcrumb-item">
                            <a href="#">
                                <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pelanggan.list') }}"> Pelanggan </a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
                    </ol>
                </nav>
                <h2 class="h4">Edit Data Pelanggan</h2>
                <p class="mb-0">Form Edit Data Pelanggan</p>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="#" class="btn btn-sm btn-info text-white d-inline-flex align-items-center">
                    Kembali
                </a>
                <div class="btn-group ms-2 ms-lg-3">
                    <button type="button" class="btn btn-sm btn-outline-gray-600">Share</button>
                    <button type="button" class="btn btn-sm btn-outline-gray-600">Export</button>
                </div>
            </div>
        </div>

        <div class="card card-body border-0 shadow mb-4">
            <h2 class="h5 mb-4">General information</h2>
            <form method="POST" action="/pelanggan/update">
                @csrf


                {{-- Tampilkan Ringkasan Error di Bagian Atas (Opsional tapi Direkomendasikan) --}}
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        Pastikan data yang Anda masukkan sudah benar.
                        <ul class="mt-2 mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div>
                            <label for="first_name">First Name</label>
                            <input class="form-control @error('first_name') is-invalid @enderror" id="first_name"
                                type="text" placeholder="Enter your first name" name="first_name"
                                value="{{ $dataPelanggan->first_name }}"> {{-- Menjaga input lama --}}

                            {{-- Menampilkan Error untuk first_name --}}
                            @error('first_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div>
                            <label for="last_name">Last Name</label>
                            <input class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                                type="text" placeholder="Also your last name" name="last_name"
                                value="{{ $dataPelanggan->last_name }}">

                            {{-- Menampilkan Error untuk last_name --}}
                            @error('last_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-6 mb-3">
                        <label for="birthday">Birthday</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <input data-datepicker="" class="form-control @error('birthday') is-invalid @enderror"
                                id="birthday" type="text" placeholder="dd/mm/yyyy" name="birthday"
                                value="{{ $dataPelanggan->birthday }}">
                        </div>
                        {{-- Menampilkan Error untuk birthday --}}
                        @error('birthday')
                            <div class="invalid-feedback d-block"> {{-- d-block agar pesan muncul --}}
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="gender">Gender</label>
                        {{-- PASTIKAN atribut name="gender" ADA --}}
                        <select class="form-select mb-0" id="gender" name="gender"
                            aria-label="Gender select example">
                            <option selected>Gender</option>
                            <option value="Female" {{ $dataPelanggan->gender == 'Female' ? 'selected' : '' }}>Female
                            </option>
                            <option value="Male" {{ $dataPelanggan->gender == 'Male' ? 'selected' : '' }}>Male
                            </option>
                        </select>

                        {{-- Menampilkan Error untuk gender --}}
                        @error('gender')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" id="email"
                                type="email" placeholder="name@company.com" name="email"
                                value="{{ $dataPelanggan->email }}">

                            {{-- Menampilkan Error untuk email --}}
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input class="form-control @error('phone') is-invalid @enderror" id="phone"
                                type="number" placeholder="+12-345 678 910" name="phone"
                                value="{{ $dataPelanggan->phone }}">

                            {{-- Menampilkan Error untuk phone --}}
                            @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-gray-800 mt-2 animate-up-2" type="submit">Simpan Perubahan</button>
                </div>

                <input type="hidden" name="pelanggan_id" value="{{ $dataPelanggan->pelanggan_id }}">

            </form>
        </div>

        <!-- End Main Content -->
@endsection

        