<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class OngkirController extends Controller
{
    public function kabupaten()
    {
        return Kabupaten::orderBy('nama_kabupaten')->get(['id_kabupaten', 'nama_kabupaten']);
    }

    public function kecamatan(Request $request)
    {
        $request->validate(['id_kabupaten' => 'required|integer|exists:kabupatens,id_kabupaten']);

        return Kecamatan::where('id_kabupaten', $request->id_kabupaten)
            ->orderBy('nama_kecamatan')
            ->get(['id_kecamatan', 'nama_kecamatan', 'ongkir']);
    }

    public function cekOngkir(Request $request)
    {
        $request->validate(['id_kecamatan' => 'required|integer|exists:kecamatans,id_kecamatan']);

        $kecamatan = Kecamatan::findOrFail($request->id_kecamatan);

        return response()->json([
            'ongkir' => (float) $kecamatan->ongkir,
        ]);
    }
}
