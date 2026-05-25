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
        Schema::table('pelanggans', function (Blueprint $table) {
            // Add status column (Online/Offline) - Online by default (from customer landing page)
            $table->enum('status', ['Online', 'Offline'])->default('Online')->after('alamat');
            
            // Add email column for customer contact - nullable
            $table->string('email')->nullable()->unique()->after('no_tlp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggans', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('email');
        });
    }
};
