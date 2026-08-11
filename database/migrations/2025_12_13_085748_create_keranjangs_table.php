<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('keranjangs', function (Blueprint $table) {
            $table->id();
            // --- KOREKSI DI SINI: Gunakan id_user ---
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); 
            // --- KOREKSI DI SINI: Gunakan id_produk ---
            $table->foreignId('id_produk')->constrained('produks')->onDelete('cascade'); 
            
            $table->integer('jumlah')->default(1); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjangs');
    }
};