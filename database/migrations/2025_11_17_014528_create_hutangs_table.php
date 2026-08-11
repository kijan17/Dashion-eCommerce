<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hutangs', function (Blueprint $table) {
            $table->id(); // id (PK)
            $table->string('nama_pelanggan');
            $table->integer('total_utang');
            $table->integer('jumlah_dibayar')->default(0);
            $table->integer('sisa_utang');
            $table->string('status', 50)->default('belum lunas');
            $table->date('tanggal');
            $table->time('jam'); // Kolom 'Jam' dari gambar
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hutangs');
    }
};
