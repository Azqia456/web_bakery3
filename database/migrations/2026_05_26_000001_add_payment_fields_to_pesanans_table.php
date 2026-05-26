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
        Schema::table('pesanans', function (Blueprint $table) {
            // Payment method
            $table->enum('metode_pembayaran', ['cash', 'transfer'])
                ->nullable()
                ->after('metode_pengambilan')
                ->comment('Metode pembayaran: cash atau transfer');

            // Payment status
            $table->enum('status_pembayaran', ['lunas', 'menunggu_verifikasi', 'belum_bayar'])
                ->default('belum_bayar')
                ->after('metode_pembayaran')
                ->comment('Status pembayaran pesanan');

            // Proof of transfer
            $table->string('bukti_transfer')
                ->nullable()
                ->after('status_pembayaran')
                ->comment('Path bukti transfer file');

            // Order notes
            $table->text('catatan_pesanan')
                ->nullable()
                ->after('bukti_transfer')
                ->comment('Catatan khusus untuk pesanan');

            // Delivery details
            $table->text('alamat_delivery')
                ->nullable()
                ->after('catatan_pesanan')
                ->comment('Alamat pengiriman untuk delivery');

            $table->date('tgl_delivery')
                ->nullable()
                ->after('alamat_delivery')
                ->comment('Tanggal pengiriman');

            // Verification date
            $table->timestamp('tgl_verifikasi')
                ->nullable()
                ->after('tgl_delivery')
                ->comment('Tanggal verifikasi pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn([
                'metode_pembayaran',
                'status_pembayaran',
                'bukti_transfer',
                'catatan_pesanan',
                'alamat_delivery',
                'tgl_delivery',
                'tgl_verifikasi',
            ]);
        });
    }
};
