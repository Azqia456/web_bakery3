<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->foreignId('id_kecamatan')->nullable()->after('id_karyawan')
                ->constrained('kecamatans', 'id_kecamatan')->nullOnDelete();
            $table->text('alamat_detail')->nullable()->after('alamat_delivery');
            $table->decimal('ongkir', 15, 2)->default(0)->after('total_bayar');
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('id_kecamatan');
            $table->dropColumn('alamat_detail');
            $table->dropColumn('ongkir');
        });
    }
};
