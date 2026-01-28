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
        Schema::table('foto_lowongan_kerjas', function (Blueprint $table) {
            $table->foreignId('opds_id')->nullable()->after('id')->constrained('opds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('foto_lowongan_kerjas', function (Blueprint $table) {
            $table->dropForeign(['opds_id']);
            $table->dropColumn('opds_id');
        });
    }
};
