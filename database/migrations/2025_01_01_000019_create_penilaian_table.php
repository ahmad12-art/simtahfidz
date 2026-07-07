<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained('semester')->cascadeOnDelete();
            $table->decimal('kelancaran', 5, 2);
            $table->decimal('tajwid', 5, 2);
            $table->decimal('makhraj', 5, 2);
            $table->decimal('adab', 5, 2);
            $table->decimal('kehadiran', 5, 2)->default(100);
            $table->decimal('nilai_akhir', 5, 2);
            $table->enum('predikat', ['A', 'B', 'C', 'D']);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['santri_id', 'semester_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
