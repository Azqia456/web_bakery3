<?php

namespace Database\Seeders;

use App\Models\Pesanan;
use App\Models\Detail_Pesanan;
use App\Models\Pelanggan;
use App\Models\Karyawan;
use App\Models\Produk;
use Illuminate\Database\Seeder;

class PesananSeeder extends Seeder
{
    public function run(): void
    {
        $karyawan = Karyawan::first();
        if (!$karyawan) {
            $karyawan = Karyawan::create([
                'nama' => 'Karyawan Default',
                'no_tlp' => '081234567890',
                'alamat' => 'Alamat Default',
                'status' => 'Aktif',
            ]);
        }

        $produkIds = Produk::pluck('id_produk')->toArray();
        if (empty($produkIds)) {
            $produk = Produk::create([
                'nama_produk' => 'Produk Default',
                'harga_produk' => 25000,
            ]);
            $produkIds = [$produk->id_produk];
        }

        $pelangganIds = Pelanggan::pluck('id_pelanggan')->toArray();
        if (empty($pelangganIds)) {
            $pelangganIds = [1];
        }

        $statuses = ['belum_lunas', 'lunas'];
        $metodePengambilan = ['pickup', 'delivery'];
        $metodePembayaran = ['cash', 'transfer'];
        $sumberPesanan = ['offline', 'online'];
        $statusPesanan = ['menunggu_konfirmasi', 'diproses', 'siap_diambil', 'dikirim', 'selesai'];

        // 30 pesanan karyawan (offline)
        for ($i = 0; $i < 30; $i++) {
            $tanggal = now()->subDays(rand(0, 60))->format('Y-m-d H:i:s');
            $total = rand(1, 5) * 25000;

            $pesanan = Pesanan::create([
                'id_karyawan' => $karyawan->id_karyawan,
                'id_pelanggan' => null,
                'tgl_pesan' => $tanggal,
                'sumber_pesanan' => 'offline',
                'status_bayar' => $statuses[array_rand($statuses)],
                'total_bayar' => $total,
            ]);

            Detail_Pesanan::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_produk' => $produkIds[array_rand($produkIds)],
                'jumlah_pesan' => rand(1, 5),
            ]);
        }

        // 30 pesanan pelanggan (offline)
        for ($i = 0; $i < 30; $i++) {
            $tanggal = now()->subDays(rand(0, 60))->format('Y-m-d H:i:s');
            $total = rand(1, 5) * 25000;
            $metode = $metodePengambilan[array_rand($metodePengambilan)];
            $pembayaran = $metodePembayaran[array_rand($metodePembayaran)];

            $pesanan = Pesanan::create([
                'id_pelanggan' => $pelangganIds[array_rand($pelangganIds)],
                'id_karyawan' => $karyawan->id_karyawan,
                'tgl_pesan' => $tanggal,
                'sumber_pesanan' => 'offline',
                'metode_pengambilan' => $metode,
                'metode_pembayaran' => $pembayaran,
                'status_pembayaran' => $pembayaran === 'cash' ? 'lunas' : 'menunggu_verifikasi',
                'status_bayar' => $statuses[array_rand($statuses)],
                'status_pesanan' => 'menunggu_konfirmasi',
                'total_bayar' => $total,
                'alamat_delivery' => $metode === 'delivery' ? fake()->address() : null,
                'tgl_delivery' => $metode === 'delivery' ? now()->addDays(rand(1, 3))->format('Y-m-d') : null,
            ]);

            Detail_Pesanan::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_produk' => $produkIds[array_rand($produkIds)],
                'jumlah_pesan' => rand(1, 5),
            ]);
        }

        $this->command->info('60 pesanan offline berhasil dibuat (30 karyawan + 30 pelanggan)');
    }
}
