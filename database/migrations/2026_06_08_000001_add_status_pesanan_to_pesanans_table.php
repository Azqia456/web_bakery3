<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->enum('status_pesanan', [
                'menunggu_konfirmasi',
                'diproses',
                'siap_diambil',
                'dikirim',
                'selesai',
            ])
            ->default('menunggu_konfirmasi')
            ->after('status_pembayaran')
            ->comment('Status proses pesanan');
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn('status_pesanan');
        });
    }
};
