<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Services\ProdukSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        // Sinkronkan data produk dan tampilkan
        $produks = ProdukSyncService::syncAll();
        return response()->json($produks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_produk' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        // Handle file upload
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $path = $gambar->store('produk', 'public');
            $validated['gambar'] = $path;
        }

        // Gunakan service untuk sinkronisasi dan mencegah duplikat
        $produk = ProdukSyncService::createProduct($validated);
        return response()->json($produk, 201);
    }

    public function show($id_produk)
    {
        $produk = Produk::findOrFail($id_produk);
        return response()->json($produk);
    }

    public function update(Request $request, $id_produk)
    {
        $produk = Produk::findOrFail($id_produk);

        $validated = $request->validate([
            'nama_produk' => 'string|max:255',
            'harga_produk' => 'numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        // Handle file upload
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }
            
            $gambar = $request->file('gambar');
            $path = $gambar->store('produk', 'public');
            $validated['gambar'] = $path;
        }

        $produk->update($validated);

        return response()->json($produk);
    }

    public function destroy($id_produk)
    {
        $produk = Produk::findOrFail($id_produk);
        
        // Hapus file gambar dari storage
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }
        
        $produk->delete();

        return response()->noContent();
    }
}
