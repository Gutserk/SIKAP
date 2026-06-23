<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survei_id')->constrained('survei')->cascadeOnDelete();
            $table->text('teks_pertanyaan');
            $table->enum('tipe_pertanyaan', ['pilihan_ganda', 'esai']);
            $table->unsignedTinyInteger('urutan');
            $table->boolean('wajib_diisi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pertanyaan');
    }
};
