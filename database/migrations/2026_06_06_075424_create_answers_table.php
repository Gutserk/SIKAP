<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengisian_id')->constrained('pengisian')->cascadeOnDelete();
            $table->foreignId('pertanyaan_id')->constrained('pertanyaan')->cascadeOnDelete();
            $table->foreignId('pilihan_id')->nullable()->constrained('pilihan')->nullOnDelete();
            $table->text('teks_jawaban')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban');
    }
};
