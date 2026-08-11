<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id(); // id (PK)
            $table->string('nama_produk', 100);
            $table->text('deskripsi')->nullable();
            $table->integer('harga');
            $table->integer('stok')->default(0);
            $table->string('gambar')->nullable(); // Menyimpan path/url ke gambar
            $table->timestamps();
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('produks');
    }
};
