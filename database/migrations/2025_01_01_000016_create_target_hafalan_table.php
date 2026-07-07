<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('target_hafalan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->cascadeOnDelete();
            $table->foreignId('guru_id')->constrained('guru')->cascadeOnDelete();
            $table->foreignId('surah_id')->constrained('surah')->restrictOnDelete();
            $table->unsignedSmallInteger('ayat_awal');
            $table->unsignedSmallInteger('ayat_akhir');
            $table->date('tanggal_mulai');
            $table->date('deadline')->nullable();
            $table->enum('status', ['berjalan', 'selesai', 'terlambat'])->default('berjalan');
            $table->decimal('persentase_progress', 5, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index(['status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('target_hafalan');
    }
};
