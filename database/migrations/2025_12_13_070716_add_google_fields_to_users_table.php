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
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom 'email' (jika belum ada) dan 'google_id'
            // Kita buat nullable karena user lama mungkin tidak punya google_id
            
            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email')->unique()->nullable()->after('username');
            }
            
            if (!Schema::hasColumn('users', 'google_id')) {
                $table->string('google_id')->nullable()->after('password');
            }

            // Ubah password jadi boleh kosong (karena login Google tidak pakai password)
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('google_id');
            // Jangan drop email sembarangan jika ada data penting
        });
    }
};