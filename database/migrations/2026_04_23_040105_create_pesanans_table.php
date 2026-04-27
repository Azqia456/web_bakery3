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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->foreignId('id_pelanggan')->constrained('pelanggans', 'id_pelanggan')->cascadeOnDelete();
            $table->foreignId('id_karyawan')->constrained('karyawans', 'id_karyawan')->cascadeOnDelete();
            $table->dateTime('tgl_pesan');
            $table->enum('sumber_pesanan', ['offline', 'online']);
            $table->enum('status_bayar', ['belum_lunas', 'lunas'])->default('belum_lunas');
            $table->decimal('total_bayar', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
