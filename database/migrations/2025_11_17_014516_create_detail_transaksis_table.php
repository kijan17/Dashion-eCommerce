<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id(); // id (PK)

            // Foreign key pertama: ke tabel 'transaksis'
            $table->foreignId('id_transaksi')->constrained('transaksis')->onDelete('cascade');

            // Foreign key kedua: ke tabel 'produks'
            $table->foreignId('id_produk')->constrained('produks')->onDelete('cascade');

            $table->integer('jumlah');
            $table->integer('harga'); // Harga saat transaksi
            $table->integer('subtotal');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
