<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Services\PesananSyncService;
use Illuminate\Http\Request;

class PesananOfflineController extends Controller
{
    /**
     * Buat pesanan offline (karyawan atau pelanggan)
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'tipe_pesanan' => 'required|in:karyawan,pelanggan',
                'nama_karyawan' => 'required_if:tipe_pesanan,karyawan|string',
                'id_karyawan' => 'required_if:tipe_pesanan,karyawan|integer|exists:karyawans,id_karyawan',
                'nama_pelanggan' => 'required_if:tipe_pesanan,pelanggan|string',
                'id_pelanggan' => 'nullable|integer|exists:pelanggans,id_pelanggan',
                'no_tlp' => 'required_if:tipe_pesanan,pelanggan|regex:/^[0-9]+$/',
                'metode_pengambilan' => 'required_if:tipe_pesanan,pelanggan|in:delivery,pickup',
                'alamat_delivery' => 'required_if:metode_pengambilan,delivery|string',
                'tgl_delivery' => 'required_if:metode_pengambilan,delivery|date',
                'tgl_pesan' => 'required|date',
                'metode_pembayaran' => 'required_if:tipe_pesanan,pelanggan|in:cash,transfer',
                'status_pembayaran' => 'in:lunas,menunggu_verifikasi,belum_bayar',
                'bukti_transfer' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'catatan_pesanan' => 'nullable|string',
                'total_bayar' => 'required|numeric|min:0',
                'products' => 'required|array|min:1',
                'products.*.id_produk' => 'required|integer|exists:produks,id_produk',
                'products.*.jumlah_pesan' => 'required|integer|min:1',
            ]);

            // Buat pesanan menggunakan service dengan sinkronisasi otomatis
            $pesanan = PesananSyncService::createPesanan(
                $validated['tipe_pesanan'],
                $validated
            );

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil disimpan ke database',
                'data' => $pesanan,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan pesanan: ' . $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Dapatkan semua pesanan offline
     */
    public function index()
    {
        try {
            $pesanan = PesananSyncService::getAllPesanan();

            return response()->json([
                'success' => true,
                'data' => $pesanan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data pesanan: ' . $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Dapatkan pesanan berdasarkan tipe (karyawan atau pelanggan)
     */
    public function getByType($type)
    {
        try {
            $pesanan = PesananSyncService::getPesananByType($type);

            return response()->json([
                'success' => true,
                'type' => $type,
                'data' => $pesanan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data pesanan: ' . $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Update pesanan offline
     */
    public function update(Request $request, $id_pesanan)
    {
        try {
            $validated = $request->validate([
                'status_bayar' => 'in:belum_lunas,lunas',
                'total_bayar' => 'numeric|min:0',
                'products' => 'array',
                'products.*.id_produk' => 'integer|exists:produks,id_produk',
                'products.*.jumlah_pesan' => 'integer|min:1',
            ]);

            $pesanan = PesananSyncService::updatePesanan($id_pesanan, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil diperbarui',
                'data' => $pesanan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui pesanan: ' . $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Hapus pesanan offline
     */
    public function destroy($id_pesanan)
    {
        try {
            PesananSyncService::deletePesanan($id_pesanan);

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus pesanan: ' . $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Verifikasi pembayaran pesanan offline
     */
    public function verifyPayment($id_pesanan)
    {
        try {
            $pesanan = Pesanan::findOrFail($id_pesanan);
            
            // Update status pembayaran menjadi lunas
            $pesanan->update([
                'status_pembayaran' => 'lunas',
                'tgl_verifikasi' => now(),
            ]);

            // Trigger sinkronisasi dashboard
            PesananSyncService::updatePesanan($id_pesanan, [
                'status_pembayaran' => 'lunas'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil diverifikasi',
                'data' => $pesanan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memverifikasi pembayaran: ' . $e->getMessage(),
            ], 400);
        }
    }
}
