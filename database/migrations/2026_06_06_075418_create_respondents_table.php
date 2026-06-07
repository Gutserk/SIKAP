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
        Schema::create('respondents', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->enum('gender', ['M', 'F']);
            $table->string('email', 150);
            $table->enum('education', ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3']);
            $table->unsignedTinyInteger('age');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respondents');
    }
};
