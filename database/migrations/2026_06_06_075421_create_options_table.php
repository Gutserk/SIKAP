<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pilihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pertanyaan_id')->constrained('pertanyaan')->cascadeOnDelete();
            $table->string('teks_pilihan', 255);
            $table->unsignedTinyInteger('urutan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pilihan');
    }
};
