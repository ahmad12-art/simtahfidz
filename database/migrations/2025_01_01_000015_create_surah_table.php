<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surah', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('nomor_surah')->unique();
            $table->string('nama_surah');
            $table->unsignedSmallInteger('jumlah_ayat');
            $table->unsignedTinyInteger('juz')->nullable();
            $table->enum('kategori', ['Makkiyah', 'Madaniyah'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surah');
    }
};
