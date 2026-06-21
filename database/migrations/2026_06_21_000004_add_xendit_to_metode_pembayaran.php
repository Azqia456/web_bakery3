<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE pesanans MODIFY COLUMN metode_pembayaran ENUM('cash','transfer','xendit') DEFAULT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE pesanans MODIFY COLUMN metode_pembayaran ENUM('cash','transfer') DEFAULT NULL");
    }
};
