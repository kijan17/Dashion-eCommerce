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
                        <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
                    </ol>
                </nav>
                <h2 class="h4">Tambah Data Pelanggan</h2>
                <p class="mb-0">Form Tambah Data Pelanggan Baru</p>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="#" class="btn btn-sm btn-success text-white d-inline-flex align-items-center">
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
            <form method="POST" action="/pelanggan/store">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops! Ada beberapa masalah dengan input Anda.</strong>
                        <ul>
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
                            <input class="form-control" id="first_name" type="text"
                                placeholder="Enter your first name" required name="first_name">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div>
                            <label for="last_name">Last Name</label>
                            <input class="form-control" id="last_name" type="text"
                                placeholder="Also your last name" required name="last_name">
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-6 mb-3">
                        <label for="birthday">Birthday</label>
                        <input class="form-control" id="birthday" type="date" required name="birthday">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="gender">Gender</label>
                        <select class="form-select mb-0" id="gender" name="gender" required>
                            <option value="" selected disabled>Pilih Gender</option>
                            <option value="male">male</option>
                            <option value="female">female</option>
                        </select>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" id="email" type="email" placeholder="name@company.com"
                                required name="email">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input class="form-control" id="phone" type="number" placeholder="+12-345 678 910"
                                required name="phone">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            </form>
        </div>

        </form>
        </div>

        <!-- End Main content -->
@endsection

        