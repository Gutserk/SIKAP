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
        Schema::create('sentiment_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('answer_id')->constrained('answers')->cascadeOnDelete();
            $table->enum('sentiment', ['positive', 'negative', 'neutral']);
            $table->decimal('score', 5, 4);
            $table->timestamp('analyzed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sentiment_results');
    }
};
