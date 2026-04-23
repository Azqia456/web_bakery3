<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        return Pembayaran::with('pesanan')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pesanan' => 'required|integer|exists:pesanans,id_pesanan',
            'tgl_pembayaran' => 'required|date',
            'jumlah_bayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:Tunai,Transfer,E-wallet',
        ]);

        return Pembayaran::create($validated);
    }

    public function show($id_pembayaran)
    {
        return Pembayaran::with('pesanan')->findOrFail($id_pembayaran);
    }

    public function update(Request $request, $id_pembayaran)
    {
        $pembayaran = Pembayaran::findOrFail($id_pembayaran);

        $validated = $request->validate([
            'id_pesanan' => 'integer|exists:pesanans,id_pesanan',
            'tgl_pembayaran' => 'date',
            'jumlah_bayar' => 'numeric|min:0',
            'metode_pembayaran' => 'in:Tunai,Transfer,E-wallet',
        ]);

        $pembayaran->update($validated);

        return $pembayaran;
    }

    public function destroy($id_pembayaran)
    {
        $pembayaran = Pembayaran::findOrFail($id_pembayaran);
        $pembayaran->delete();

        return response()->noContent();
    }
}
