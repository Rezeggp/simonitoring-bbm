<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spbus', function (Blueprint $table) {
            $table->id();
            $table->string('kode_spbu')->unique();
            $table->string('nama_spbu');
            $table->string('alamat');
            $table->string('wilayah')->nullable();
            $table->string('pemilik')->nullable();
            $table->string('telepon')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spbus');
    }
};
