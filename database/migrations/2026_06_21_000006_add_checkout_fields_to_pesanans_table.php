<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->string('checkout_url')->nullable()->after('ongkir');
            $table->timestamp('checkout_expired_at')->nullable()->after('checkout_url');
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn(['checkout_url', 'checkout_expired_at']);
        });
    }
};
