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
        Schema::create('jadwalkegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('namakegiatan');
            $table->string('lokasi');
            $table->date('tanggalkegiatan');
            $table->time('jamkegiatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwalkegiatan');
    }
};
