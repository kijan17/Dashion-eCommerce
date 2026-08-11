<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'harga',
        'stok',
        'gambar',
        'id_kategori', // <-- TAMBAHAN INI (Foreign Key)
    ];
    
    // Definisikan relasi ke Kategori
    public function kategori()
    {
        // Foreign key di tabel Produk adalah 'id_kategori'
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}