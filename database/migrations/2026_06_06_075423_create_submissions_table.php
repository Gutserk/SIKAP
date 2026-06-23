<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengisian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responden_id')->constrained('responden')->restrictOnDelete();
            $table->foreignId('survei_id')->constrained('survei')->cascadeOnDelete();
            $table->timestamp('dikirim_pada')->useCurrent();

            $table->unique(['responden_id', 'survei_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengisian');
    }
};
