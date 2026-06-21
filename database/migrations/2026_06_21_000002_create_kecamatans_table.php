<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kecamatans', function (Blueprint $table) {
            $table->id('id_kecamatan');
            $table->foreignId('id_kabupaten')->constrained('kabupatens', 'id_kabupaten')->cascadeOnDelete();
            $table->string('nama_kecamatan');
            $table->decimal('ongkir', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kecamatans');
    }
};
