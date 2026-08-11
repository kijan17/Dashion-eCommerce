<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            // Tambahkan foreign key id_kategori
            // 'nullable()' penting jika tabel 'produks' sudah ada isinya
            $table->foreignId('id_kategori')->nullable()->after('id')
                  ->constrained('kategoris')->onDelete('set null'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            // Hapus foreign key dan kolom jika rollback
            $table->dropForeign(['id_kategori']);
            $table->dropColumn('id_kategori');
        });
    }
};