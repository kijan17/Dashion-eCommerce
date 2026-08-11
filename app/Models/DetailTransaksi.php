<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    // Ganti nama tabel jika tidak sesuai standar laravel (cth: detail_transaksi)
    // protected $table = 'detail_transaksis';

    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'jumlah',
        'harga',
        'subtotal',
    ];
}
