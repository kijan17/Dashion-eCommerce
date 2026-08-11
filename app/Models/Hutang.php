<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hutang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelanggan',
        'total_utang',
        'jumlah_dibayar',
        'sisa_utang',
        'status',
        'tanggal',
        'jam',
    ];
}
