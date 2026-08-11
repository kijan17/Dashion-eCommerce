<?php

use Illuminate\Support\Facades\Route;

// --- 1. IMPORT SEMUA CONTROLLER (Wajib Ada) ---
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardOwnerController;

// Controller CRUD & Fitur
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\HutangController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 2. HALAMAN PUBLIK ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk-katalog', [PembeliController::class, 'index'])->name('pembeli.produk'); 


// --- 3. OTENTIKASI ---
Route::get('auth/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('auth/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('auth/register', [AuthController::class, 'showRegistrationForm'])->name('register.form');
Route::post('auth/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('auth/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Google Socialite (PENTING untuk Login/Daftar Google)
Route::get('/auth/redirect-google', [AuthController::class, 'redirectToGoogle'])->name('redirect.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']); 


// --- 4. HALAMAN KHUSUS USER LOGIN (Middleware 'auth') ---
Route::middleware(['auth'])->group(function () {

    // A. Dashboard ADMIN
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // B. Dashboard OWNER
    Route::get('/dashboard', [DashboardOwnerController::class, 'index'])->name('dashboard');

    // C. CRUD PRODUK & KATEGORI
    Route::resource('produk', ProdukController::class);
    Route::resource('kategori', KategoriController::class)->except(['create', 'show', 'edit']); 
    
    // D. Fitur Hutang (Owner)
    Route::get('/hutang/riwayat', [HutangController::class, 'riwayat'])->name('hutang.riwayat');
    Route::resource('hutang', HutangController::class);

    // E. Fitur Pembeli
    Route::resource('keranjang', KeranjangController::class);
    Route::get('/history', [TransaksiController::class, 'index'])->name('transaksi.history'); 

    // F. CRUD Lainnya
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('detail-transaksi', DetailTransaksiController::class);
    Route::resource('user', UserController::class);

});