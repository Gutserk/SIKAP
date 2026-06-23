<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE pertanyaan MODIFY COLUMN tipe_pertanyaan ENUM('pilihan_ganda', 'esai', 'skala_linear') NOT NULL");

        Schema::table('pertanyaan', function (Blueprint $table) {
            $table->unsignedTinyInteger('skala_min')->nullable()->default(1);
            $table->unsignedTinyInteger('skala_max')->nullable()->default(5);
            $table->string('skala_min_label', 100)->nullable();
            $table->string('skala_max_label', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pertanyaan', function (Blueprint $table) {
            $table->dropColumn(['skala_min', 'skala_max', 'skala_min_label', 'skala_max_label']);
        });

        DB::statement("ALTER TABLE pertanyaan MODIFY COLUMN tipe_pertanyaan ENUM('pilihan_ganda', 'esai') NOT NULL");
    }
};
