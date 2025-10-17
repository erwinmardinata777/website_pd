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
        Schema::create('foto_lowongan_kerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lowongan_kerjas_id')->constrained('lowongan_kerjas')->cascadeOnDelete();
            $table->string('foto');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_lowongan_kerjas');
    }
};
