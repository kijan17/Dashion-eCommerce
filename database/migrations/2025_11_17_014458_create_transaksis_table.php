<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id(); // id (PK)

            // Foreign Key ke tabel 'users'
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');

            $table->integer('total');
            $table->string('metode', 50);
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
};
