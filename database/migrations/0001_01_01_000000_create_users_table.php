<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Hapus tabel 'users' lama jika ada (dari bawaan Laravel)
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table) {
            $table->id(); // id (PK)
            $table->string('username')->unique();
            $table->string('password');
            $table->string('role', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
