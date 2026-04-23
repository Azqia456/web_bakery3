<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        return Karyawan::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_tlp' => 'required|string|max:50',
            'alamat' => 'required|string',
        ]);

        return Karyawan::create($validated);
    }

    public function show($id_karyawan)
    {
        return Karyawan::findOrFail($id_karyawan);
    }

    public function update(Request $request, $id_karyawan)
    {
        $karyawan = Karyawan::findOrFail($id_karyawan);

        $validated = $request->validate([
            'nama' => 'string|max:255',
            'no_tlp' => 'string|max:50',
            'alamat' => 'string',
        ]);

        $karyawan->update($validated);

        return $karyawan;
    }

    public function destroy($id_karyawan)
    {
        $karyawan = Karyawan::findOrFail($id_karyawan);
        $karyawan->delete();

        return response()->noContent();
    }
}
