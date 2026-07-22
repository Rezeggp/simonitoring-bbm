<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('distribusis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_distribusi')->unique();
            $table->foreignId('depot_id')->constrained('depots');
            $table->foreignId('spbu_id')->constrained('spbus');
            $table->foreignId('jenis_bbm_id')->constrained('jenis_bbms');
            $table->decimal('jumlah_liter', 14, 2);
            $table->string('nama_supir')->nullable();
            $table->string('no_polisi')->nullable();
            $table->enum('status', ['menunggu', 'diproses', 'dikirim', 'diterima', 'dibatalkan'])->default('menunggu');
            $table->dateTime('tanggal_permintaan');
            $table->dateTime('tanggal_proses')->nullable();
            $table->dateTime('tanggal_kirim')->nullable();
            $table->dateTime('tanggal_terima')->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distribusis');
    }
};
