<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_sentimen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jawaban_id')->constrained('jawaban')->cascadeOnDelete();
            $table->enum('sentimen', ['positif', 'negatif', 'netral']);
            $table->decimal('skor', 5, 4);
            $table->timestamp('dianalisis_pada')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_sentimen');
    }
};
