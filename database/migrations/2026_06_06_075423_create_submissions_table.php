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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('respondent_id')->constrained('respondents')->restrictOnDelete();
            $table->foreignId('survey_id')->constrained('surveys')->cascadeOnDelete();
            $table->timestamp('submitted_at')->useCurrent();
            
            $table->unique(['respondent_id', 'survey_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
