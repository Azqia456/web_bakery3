<?php

namespace App\Http\Controllers;

use App\Models\Detail_Pesanan;
use Illuminate\Http\Request;

class DetailPesananController extends Controller
{
    public function index()
    {
        return Detail_Pesanan::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pesanan' => 'required|integer|exists:pesanans,id_pesanan',
            'id_produk' => 'required|integer|exists:produks,id_produk',
            'jumlah_pesan' => 'required|integer|min:1',
        ]);

        return Detail_Pesanan::create($validated);
    }

    public function show($id_pesanan, $id_produk)
    {
        return Detail_Pesanan::where('id_pesanan', $id_pesanan)
            ->where('id_produk', $id_produk)
            ->firstOrFail();
    }

    public function update(Request $request, $id_pesanan, $id_produk)
    {
        $detail = Detail_Pesanan::where('id_pesanan', $id_pesanan)
            ->where('id_produk', $id_produk)
            ->firstOrFail();

        $validated = $request->validate([
            'jumlah_pesan' => 'integer|min:1',
        ]);

        $detail->update($validated);

        return $detail;
    }

    public function destroy($id_pesanan, $id_produk)
    {
        $detail = Detail_Pesanan::where('id_pesanan', $id_pesanan)
            ->where('id_produk', $id_produk)
            ->firstOrFail();

        $detail->delete();

        return response()->noContent();
    }
}
