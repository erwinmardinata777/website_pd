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
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('deskripsi')->nullable();
            $table->longText('isi');
            $table->string('penulis')->nullable();
            $table->string('thumb')->nullable();
            $table->enum('status', ['aktif', 'tidak aktif'])->default('aktif');
            $table->date('tanggal')->nullable();
            $table->unsignedBigInteger('hits')->default(0);            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
