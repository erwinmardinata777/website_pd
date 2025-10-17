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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->text('alamat')->nullable();
            $table->string('status_kawin')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('jabatan')->nullable();
            $table->unsignedBigInteger('parent')->nullable();
            $table->unsignedBigInteger('bidangs_id')->nullable();
            $table->string('nip')->nullable();
            $table->string('pangkat_golongan')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('foto')->nullable();            
            $table->timestamps();

            // Relasi
            $table->foreign('bidangs_id')->references('id')->on('bidangs')->onDelete('set null');
            $table->foreign('parent')->references('id')->on('pegawais')->onDelete('set null');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
