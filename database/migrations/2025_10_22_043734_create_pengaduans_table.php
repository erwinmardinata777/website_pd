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
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('telp')->nullable();
            $table->string('alamat')->nullable();
            $table->string('kode_kecamatan');
            $table->string('kode_desa');
            $table->string('pengaduan');
            $table->text('isi_pengaduan')->nullable();
            $table->string('bukti')->nullable(); // upload bukti gambar/file
            $table->tinyInteger('status')->default(0); // 0=baru,1=proses,2=selesai
            $table->date('tanggal_pengaduan');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
