<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Services\XenditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;

class XenditController extends Controller
{
    protected XenditService $xenditService;

    public function __construct(XenditService $xenditService)
    {
        $this->xenditService = $xenditService;
    }

    public function createInvoice(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|string',
            'metode_pengambilan' => 'required|in:pickup,delivery',
            'id_kecamatan' => 'nullable|integer|exists:kecamatans,id_kecamatan',
            'alamat_detail' => 'nullable|string|max:500',
            'alamat_delivery' => 'nullable|string|max:500',
            'tgl_delivery' => 'nullable|date|after_or_equal:' . now()->addDays(2)->format('Y-m-d'),
            'tgl_pickup' => 'nullable|date|after_or_equal:' . now()->addDays(2)->format('Y-m-d'),
        ]);

        $user = Auth::user();
        $pelanggan = $user->pelanggan;

        if (!$pelanggan) {
            return response()->json(['success' => false, 'message' => 'Data pelanggan tidak ditemukan.'], 422);
        }

        $items = json_decode($validated['items'], true);
        if (!is_array($items) || empty($items)) {
            return response()->json(['success' => false, 'message' => 'Item pesanan tidak valid.'], 422);
        }

        $products = [];
        $subtotal = 0;
        foreach ($items as $item) {
            $productId = (int) ($item['id_produk'] ?? 0);
            $quantity = max(1, (int) ($item['quantity'] ?? 1));
            $harga = (int) ($item['harga_produk'] ?? 0);

            if ($productId <= 0) continue;

            $products[] = [
                'id_produk' => $productId,
                'jumlah_pesan' => $quantity,
            ];
            $subtotal += $harga * $quantity;
        }

        foreach ($items as $item) {
            $qty = max(1, (int) ($item['quantity'] ?? 1));
            if ($qty < 100) {
                return response()->json([
                    'success' => false,
                    'message' => 'Minimal pembelian 100 unit per produk. "' . ($item['nama_produk'] ?? 'Produk') . '" hanya ' . $qty . ' unit.',
                ], 422);
            }
        }

        $pesanan = \App\Services\PesananSyncService::createPesananPelanggan([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'id_karyawan' => null,
            'tgl_pesan' => now(),
            'sumber_pesanan' => 'online',
            'metode_pengambilan' => $validated['metode_pengambilan'] ?? 'pickup',
            'id_kecamatan' => $validated['id_kecamatan'] ?? null,
            'alamat_delivery' => $validated['alamat_delivery'] ?? null,
            'alamat_detail' => $validated['alamat_detail'] ?? null,
            'tgl_delivery' => $validated['tgl_delivery'] ?? null,
            'tgl_pickup' => $validated['tgl_pickup'] ?? null,
            'metode_pembayaran' => 'xendit',
            'status_pembayaran' => 'belum_bayar',
            'status_bayar' => 'belum_lunas',
            'total_bayar' => $subtotal,
            'products' => $products,
        ]);

        try {
            $customerData = [
                'name' => $pelanggan->nama,
                'email' => $pelanggan->email ?? $user->email,
                'phone' => $pelanggan->no_tlp ?? '',
            ];

            $result = $this->xenditService->createInvoice($pesanan, $customerData, $items);

            return response()->json([
                'success' => true,
                'message' => 'Invoice Xendit berhasil dibuat.',
                'data' => [
                    'id_pesanan' => $pesanan->id_pesanan,
                    'invoice_url' => $result['invoice_url'],
                    'external_id' => $result['external_id'],
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Xendit create invoice error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            $pesanan->delete();

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pembayaran: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function callback(Request $request)
    {
        Log::info('Xendit callback received', $request->all());

        $externalId = $request->input('external_id');
        $status = $request->input('status');

        if (!$externalId || !$status) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        $pesananId = null;
        if (preg_match('/^BAKERY-(\d+)-/', $externalId, $matches)) {
            $pesananId = (int) $matches[1];
        }

        if (!$pesananId) {
            return response()->json(['error' => 'Invalid external_id format'], 400);
        }

        $pesanan = Pesanan::find($pesananId);
        if (!$pesanan) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        if ($status === 'PAID') {
            $pesanan->update([
                'status_pembayaran' => 'lunas',
                'status_bayar' => 'lunas',
                'status_pesanan' => 'diproses',
                'tgl_verifikasi' => now(),
            ]);

            Log::info("Xendit payment verified for pesanan #{$pesananId}");
        } elseif (in_array($status, ['EXPIRED', 'FAILED'])) {
            $pesanan->update([
                'status_pembayaran' => 'belum_bayar',
            ]);

            Log::info("Xendit payment {$status} for pesanan #{$pesananId}");
        }

        return response()->json(['success' => true]);
    }

    public function success(Request $request)
    {
        $externalId = $request->input('external_id');

        return view('xendit.success', compact('externalId'));
    }

    public function failed(Request $request)
    {
        $externalId = $request->input('external_id');

        return view('xendit.failed', compact('externalId'));
    }

    public function pending(Request $request)
    {
        $externalId = $request->input('external_id');

        return view('xendit.pending', compact('externalId'));
    }
}
