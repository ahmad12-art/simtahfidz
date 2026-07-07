<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('murajaah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->cascadeOnDelete();
            $table->foreignId('guru_id')->constrained('guru')->cascadeOnDelete();
            $table->foreignId('surah_id')->constrained('surah')->restrictOnDelete();
            $table->date('tanggal');
            $table->unsignedSmallInteger('ayat_awal');
            $table->unsignedSmallInteger('ayat_akhir');
            $table->decimal('nilai_kelancaran', 5, 2);
            $table->decimal('nilai_tajwid', 5, 2);
            $table->decimal('nilai_makhraj', 5, 2);
            $table->decimal('nilai_akhir', 5, 2);
            $table->enum('status', ['lancar', 'mengulang', 'belum_lancar'])->default('lancar');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index(['tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('murajaah');
    }
};
