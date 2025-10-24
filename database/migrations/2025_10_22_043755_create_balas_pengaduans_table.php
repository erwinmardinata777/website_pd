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
        Schema::create('balas_pengaduans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduans_id')->constrained('pengaduans')->onDelete('cascade');
            $table->text('tanggapan');
            $table->date('tanggal_balas');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balas_pengaduans');
    }
};
