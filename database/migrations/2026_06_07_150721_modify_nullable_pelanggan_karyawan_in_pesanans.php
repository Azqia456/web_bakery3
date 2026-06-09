<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE pesanans DROP FOREIGN KEY pesanans_id_pelanggan_foreign');
        DB::statement('ALTER TABLE pesanans DROP FOREIGN KEY pesanans_id_karyawan_foreign');

        DB::statement('ALTER TABLE pesanans MODIFY id_pelanggan BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE pesanans MODIFY id_karyawan BIGINT UNSIGNED NULL');

        DB::statement('ALTER TABLE pesanans ADD CONSTRAINT pesanans_id_pelanggan_foreign FOREIGN KEY (id_pelanggan) REFERENCES pelanggans(id_pelanggan) ON DELETE CASCADE');
        DB::statement('ALTER TABLE pesanans ADD CONSTRAINT pesanans_id_karyawan_foreign FOREIGN KEY (id_karyawan) REFERENCES karyawans(id_karyawan) ON DELETE CASCADE');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE pesanans DROP FOREIGN KEY pesanans_id_pelanggan_foreign');
        DB::statement('ALTER TABLE pesanans DROP FOREIGN KEY pesanans_id_karyawan_foreign');

        DB::statement('ALTER TABLE pesanans MODIFY id_pelanggan BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE pesanans MODIFY id_karyawan BIGINT UNSIGNED NOT NULL');

        DB::statement('ALTER TABLE pesanans ADD CONSTRAINT pesanans_id_pelanggan_foreign FOREIGN KEY (id_pelanggan) REFERENCES pelanggans(id_pelanggan) ON DELETE CASCADE');
        DB::statement('ALTER TABLE pesanans ADD CONSTRAINT pesanans_id_karyawan_foreign FOREIGN KEY (id_karyawan) REFERENCES karyawans(id_karyawan) ON DELETE CASCADE');
    }
};
