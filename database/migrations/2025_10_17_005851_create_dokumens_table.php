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
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_dokumens_id')->nullable()->constrained('kategori_dokumens')->onDelete('set null');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('type_file', ['url', 'file', 'text'])->default('file');
            $table->text('url')->nullable();
            $table->string('file')->nullable();
            $table->longText('text')->nullable();
            $table->date('tanggal')->default(now());
            $table->integer('hits')->default(0);
            $table->integer('download')->default(0);
            $table->boolean('status')->default(1);            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
