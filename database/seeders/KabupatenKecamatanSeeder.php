<?php

namespace Database\Seeders;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use Illuminate\Database\Seeder;

class KabupatenKecamatanSeeder extends Seeder
{
    public function run(): void
    {
        $kabupatenData = [
            'Kota Bandung' => [
                ['nama_kecamatan' => 'Cidadap', 'ongkir' => 10000],
                ['nama_kecamatan' => 'Coblong', 'ongkir' => 9000],
                ['nama_kecamatan' => 'Sukajadi', 'ongkir' => 8000],
                ['nama_kecamatan' => 'Bandung Wetan', 'ongkir' => 9000],
                ['nama_kecamatan' => 'Cibeunying Kaler', 'ongkir' => 10000],
                ['nama_kecamatan' => 'Cibeunying Kidul', 'ongkir' => 10000],
                ['nama_kecamatan' => 'Antapani', 'ongkir' => 11000],
                ['nama_kecamatan' => 'Arcamanik', 'ongkir' => 12000],
                ['nama_kecamatan' => 'Kiaracondong', 'ongkir' => 11000],
                ['nama_kecamatan' => 'Batununggal', 'ongkir' => 10000],
                ['nama_kecamatan' => 'Bojongloa Kaler', 'ongkir' => 9000],
                ['nama_kecamatan' => 'Bojongloa Kidul', 'ongkir' => 9000],
                ['nama_kecamatan' => 'Regol', 'ongkir' => 8000],
                ['nama_kecamatan' => 'Lengkong', 'ongkir' => 8000],
                ['nama_kecamatan' => 'Sumur Bandung', 'ongkir' => 7000],
                ['nama_kecamatan' => 'Andir', 'ongkir' => 7000],
                ['nama_kecamatan' => 'Cicendo', 'ongkir' => 7000],
                ['nama_kecamatan' => 'Astanaanyar', 'ongkir' => 8000],
                ['nama_kecamatan' => 'Ujungberung', 'ongkir' => 13000],
                ['nama_kecamatan' => 'Gedebage', 'ongkir' => 14000],
                ['nama_kecamatan' => 'Panyileukan', 'ongkir' => 13000],
                ['nama_kecamatan' => 'Cinambo', 'ongkir' => 14000],
                ['nama_kecamatan' => 'Mandalajati', 'ongkir' => 12000],
                ['nama_kecamatan' => 'Rancasari', 'ongkir' => 13000],
                ['nama_kecamatan' => 'Buahbatu', 'ongkir' => 12000],
                ['nama_kecamatan' => 'Margacinta', 'ongkir' => 12000],
                ['nama_kecamatan' => 'Babakan Ciparay', 'ongkir' => 10000],
                ['nama_kecamatan' => 'Sukasari', 'ongkir' => 8000],
            ],
            'Kabupaten Bandung' => [
                ['nama_kecamatan' => 'Soreang', 'ongkir' => 15000],
                ['nama_kecamatan' => 'Margahayu', 'ongkir' => 14000],
                ['nama_kecamatan' => 'Dayeuhkolot', 'ongkir' => 13000],
                ['nama_kecamatan' => 'Banjaran', 'ongkir' => 16000],
                ['nama_kecamatan' => 'Ciparay', 'ongkir' => 17000],
                ['nama_kecamatan' => 'Majasari', 'ongkir' => 15000],
                ['nama_kecamatan' => 'Baleendah', 'ongkir' => 13000],
                ['nama_kecamatan' => 'Bojongsoang', 'ongkir' => 14000],
                ['nama_kecamatan' => 'Katapang', 'ongkir' => 15000],
            ],
            'Kota Cimahi' => [
                ['nama_kecamatan' => 'Cimahi Selatan', 'ongkir' => 12000],
                ['nama_kecamatan' => 'Cimahi Tengah', 'ongkir' => 11000],
                ['nama_kecamatan' => 'Cimahi Utara', 'ongkir' => 11000],
            ],
            'Kabupaten Bandung Barat' => [
                ['nama_kecamatan' => 'Ngamprah', 'ongkir' => 16000],
                ['nama_kecamatan' => 'Padalarang', 'ongkir' => 17000],
                ['nama_kecamatan' => 'Batujajar', 'ongkir' => 18000],
                ['nama_kecamatan' => 'Cisarua', 'ongkir' => 20000],
                ['nama_kecamatan' => 'Lembang', 'ongkir' => 19000],
                ['nama_kecamatan' => 'Parongpong', 'ongkir' => 18000],
            ],
            'Kabupaten Karawang' => [
                ['nama_kecamatan' => 'Banyusari', 'ongkir' => 25000],
                ['nama_kecamatan' => 'Batujaya', 'ongkir' => 27000],
                ['nama_kecamatan' => 'Ciampel', 'ongkir' => 24000],
                ['nama_kecamatan' => 'Cibuaya', 'ongkir' => 28000],
                ['nama_kecamatan' => 'Cikampek', 'ongkir' => 22000],
                ['nama_kecamatan' => 'Cilamaya Kulon', 'ongkir' => 28000],
                ['nama_kecamatan' => 'Cilamaya Wetan', 'ongkir' => 29000],
                ['nama_kecamatan' => 'Cilebar', 'ongkir' => 26000],
                ['nama_kecamatan' => 'Jatisari', 'ongkir' => 23000],
                ['nama_kecamatan' => 'Jayakerta', 'ongkir' => 25000],
                ['nama_kecamatan' => 'Karawang Barat', 'ongkir' => 21000],
                ['nama_kecamatan' => 'Karawang Timur', 'ongkir' => 21000],
                ['nama_kecamatan' => 'Klari', 'ongkir' => 22000],
                ['nama_kecamatan' => 'Kotabaru', 'ongkir' => 24000],
                ['nama_kecamatan' => 'Kutawaluya', 'ongkir' => 26000],
                ['nama_kecamatan' => 'Lemahabang', 'ongkir' => 25000],
                ['nama_kecamatan' => 'Majalaya', 'ongkir' => 23000],
                ['nama_kecamatan' => 'Pakisjaya', 'ongkir' => 30000],
                ['nama_kecamatan' => 'Pangkalan', 'ongkir' => 27000],
                ['nama_kecamatan' => 'Pedes', 'ongkir' => 26000],
                ['nama_kecamatan' => 'Purwasari', 'ongkir' => 23000],
            ],
        ];

        foreach ($kabupatenData as $namaKabupaten => $kecamatans) {
            $kabupaten = Kabupaten::create(['nama_kabupaten' => $namaKabupaten]);

            foreach ($kecamatans as $kec) {
                Kecamatan::create([
                    'id_kabupaten' => $kabupaten->id_kabupaten,
                    'nama_kecamatan' => $kec['nama_kecamatan'],
                    'ongkir' => $kec['ongkir'],
                ]);
            }
        }
    }
}
