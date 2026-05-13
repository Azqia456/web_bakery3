<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Services\ProdukSyncService;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        // Sinkronkan data produk dan tampilkan
        return ProdukSyncService::syncAll();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_produk' => 'required|numeric|min:0',
        ]);

        // Gunakan service untuk sinkronisasi dan mencegah duplikat
        return ProdukSyncService::createProduct($validated);
    }

    public function show($id_produk)
    {
        return Produk::findOrFail($id_produk);
    }

    public function update(Request $request, $id_produk)
    {
        $produk = Produk::findOrFail($id_produk);

        $validated = $request->validate([
            'nama_produk' => 'string|max:255',
            'harga_produk' => 'numeric|min:0',
        ]);

        $produk->update($validated);

        return $produk;
    }

    public function destroy($id_produk)
    {
        $produk = Produk::findOrFail($id_produk);
        $produk->delete();

        return response()->noContent();
    }
}
