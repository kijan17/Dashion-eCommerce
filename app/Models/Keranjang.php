<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    
    // Pastikan fillable sudah benar!
    protected $fillable = [
        'id_user',
        'id_produk',
        'jumlah',
    ];

    // Relasi ke Produk
    public function produk()
    {
        // Foreign key di tabel Keranjang adalah 'id_produk'
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    // Relasi ke User
    public function user()
    {
        // Foreign key di tabel Keranjang adalah 'id_user'
        return $this->belongsTo(User::class, 'id_user');
    }
}