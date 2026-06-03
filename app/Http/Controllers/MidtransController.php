<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Throwable;

class MidtransController extends Controller
{
    public function createSnapToken(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:qris,dana',
            'items' => 'required|array|min:1',
            'items.*.nama_produk' => 'required|string|max:255',
            'items.*.harga_produk' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        if (! config('midtrans.server_key') || ! config('midtrans.client_key')) {
            return response()->json([
                'message' => 'Midtrans belum dikonfigurasi. Isi MIDTRANS_SERVER_KEY dan MIDTRANS_CLIENT_KEY terlebih dahulu.',
            ], 422);
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $orderId = 'TRX-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(6));
        $itemDetails = [];
        $grossAmount = 0;

        foreach ($validated['items'] as $item) {
            $price = (int) round((float) $item['harga_produk']);
            $quantity = (int) $item['quantity'];
            $grossAmount += $price * $quantity;

            $itemDetails[] = [
                'id' => (string) ($item['id_produk'] ?? Str::slug($item['nama_produk'])),
                'price' => $price,
                'quantity' => $quantity,
                'name' => Str::limit($item['nama_produk'], 50),
            ];
        }

        $user = Auth::user();
        $customer = $user?->pelanggan;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $customer->nama ?? $user?->username ?? 'Pelanggan Bakery',
                'email' => $customer->email ?? $user?->email,
                'phone' => $customer->no_tlp ?? null,
            ],
            'enabled_payments' => [
                'qris',
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'message' => 'Snap token berhasil dibuat',
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
                'selected_method' => $validated['payment_method'],
                'payment_label' => $validated['payment_method'] === 'dana' ? 'DANA via QRIS' : 'QRIS',
                'midtrans_client_key' => config('midtrans.client_key'),
                'is_production' => config('midtrans.is_production'),
            ]);
        } catch (Throwable $throwable) {
            Log::error('Midtrans Snap token creation failed', [
                'message' => $throwable->getMessage(),
                'order_id' => $orderId,
                'user_id' => $user?->id_user ?? null,
                'gross_amount' => $grossAmount,
            ]);

            return response()->json([
                'message' => 'Midtrans gagal membuat token pembayaran.',
                'error' => app()->environment('local') ? $throwable->getMessage() : 'Silakan coba lagi.',
            ], 422);
        }
    }
}