<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('survei', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admin')->restrictOnDelete();
            $table->string('judul', 200);
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['draf', 'aktif', 'ditutup'])->default('draf');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survei');
    }
};
