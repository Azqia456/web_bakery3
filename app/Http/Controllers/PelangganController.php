<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        return Pelanggan::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user' => 'required|integer|exists:users,id_user',
            'nama' => 'required|string|max:255',
            'no_tlp' => 'required|string|max:50',
            'alamat' => 'required|string',
        ]);

        return Pelanggan::create($validated);
    }

    public function show($id_pelanggan)
    {
        return Pelanggan::findOrFail($id_pelanggan);
    }

    public function update(Request $request, $id_pelanggan)
    {
        $pelanggan = Pelanggan::findOrFail($id_pelanggan);

        $validated = $request->validate([
            'id_user' => 'integer|exists:users,id_user',
            'nama' => 'string|max:255',
            'no_tlp' => 'string|max:50',
            'alamat' => 'string',
        ]);

        $pelanggan->update($validated);

        return $pelanggan;
    }

    public function destroy($id_pelanggan)
    {
        $pelanggan = Pelanggan::findOrFail($id_pelanggan);
        $pelanggan->delete();

        return response()->noContent();
    }
}
