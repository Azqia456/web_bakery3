<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Services\PesananSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PesananController extends Controller
{
    public function view()
    {
        return view('pesanan');
    }

    public function pelangganView()
    {
        return view('dashboard.pesanan-pelanggan');
    }

    public function index()
    {
        // Dapatkan semua pesanan yang sudah tersinkronkan
        return PesananSyncService::getAllPesanan();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pelanggan' => 'required|integer|exists:pelanggans,id_pelanggan',
            'id_karyawan' => 'required|integer|exists:karyawans,id_karyawan',
            'tgl_pesan' => 'required|date',
            'status_bayar' => 'required|in:belum_lunas,lunas',
            'total_bayar' => 'required|numeric|min:0',
        ]);

        // Gunakan service untuk sinkronisasi pesanan
        return PesananSyncService::updatePesanan(null, $validated);
    }

    public function show($id_pesanan)
    {
        $pesanan = Pesanan::with(['pelanggan', 'karyawan', 'detailPesanans', 'pembayarans'])
            ->findOrFail($id_pesanan);
        
        return $pesanan;
    }

    public function update(Request $request, $id_pesanan)
    {
        $validated = $request->validate([
            'id_pelanggan' => 'integer|exists:pelanggans,id_pelanggan',
            'id_karyawan' => 'integer|exists:karyawans,id_karyawan',
            'tgl_pesan' => 'date',
            'status_bayar' => 'in:belum_lunas,lunas',
            'total_bayar' => 'numeric|min:0',
            'products' => 'array',
        ]);

        // Gunakan service untuk update dengan sinkronisasi
        return PesananSyncService::updatePesanan($id_pesanan, $validated);
    }

    public function destroy($id_pesanan)
    {
        // Gunakan service untuk hapus dengan sinkronisasi
        PesananSyncService::deletePesanan($id_pesanan);

        return response()->noContent();
    }

    public function offline()
    {
        return view('pesanan-offline');
    }

    public function online()
    {
        return view('pesanan-online');
    }

    public function confirmPaymentProof(Request $request)
    {
        $validated = $request->validate([
            'order_reference' => 'nullable|string|max:100',
            'nama_pengirim' => 'nullable|string|max:255',
            'bank_pengirim' => 'nullable|string|max:100',
            'nominal_transfer' => 'nullable|numeric|min:0',
            'bukti_transfer' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'catatan_pembayaran' => 'nullable|string|max:1000',
            'items' => 'nullable|string',
        ]);

        $customer = Auth::user()?->pelanggan;

        if (! $customer) {
            return response()->json([
                'success' => false,
                'message' => 'Data pelanggan tidak ditemukan untuk akun ini.',
            ], 422);
        }

        $items = json_decode($validated['items'] ?? '[]', true);
        $expectedTotal = (int) round((float) ($validated['nominal_transfer'] ?? 0));
        $products = [];

        if (is_array($items)) {
            foreach ($items as $item) {
                $productId = (int) ($item['id_produk'] ?? 0);
                $quantity = max(1, (int) ($item['quantity'] ?? 1));

                if ($productId <= 0) {
                    continue;
                }

                $products[] = [
                    'id_produk' => $productId,
                    'jumlah_pesan' => $quantity,
                ];
            }
        }

        $buktiPath = $request->file('bukti_transfer')->store('bukti-transfer', 'public');
        $catatan = trim(implode(' | ', array_filter([
            'Referensi: ' . ($validated['order_reference'] ?? '-'),
            'Pengirim: ' . ($validated['nama_pengirim'] ?? '-'),
            'Bank: ' . ($validated['bank_pengirim'] ?? '-'),
            'Nominal: ' . ($validated['nominal_transfer'] ?? 0),
            $validated['catatan_pembayaran'] ?? null,
        ])));

        $pesanan = PesananSyncService::createPesananPelanggan([
            'id_pelanggan' => $customer->id_pelanggan,
            'nama_pelanggan' => $customer->nama,
            'no_tlp' => $customer->no_tlp ?? $customer->no_hp ?? null,
            'id_karyawan' => null,
            'tgl_pesan' => now(),
            'sumber_pesanan' => 'online',
            'metode_pengambilan' => 'pickup',
            'metode_pembayaran' => 'transfer',
            'status_pembayaran' => 'menunggu_verifikasi',
            'bukti_transfer' => $buktiPath,
            'catatan_pesanan' => $catatan,
            'status_bayar' => 'belum_lunas',
            'total_bayar' => $expectedTotal,
            'products' => $products,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bukti pembayaran berhasil dikirim. Pesanan menunggu verifikasi.',
            'data' => [
                'id_pesanan' => $pesanan->id_pesanan,
                'total_bayar' => $expectedTotal,
                'bukti_transfer_url' => Storage::url($buktiPath),
            ],
        ]);
    }
}
