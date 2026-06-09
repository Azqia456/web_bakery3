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
            'status' => 'sometimes|in:Aktif,Nonaktif',
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
            'status' => 'sometimes|in:Aktif,Nonaktif',
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

    public function autocomplete(Request $request)
    {
        $search = $request->query('q', '');

        if (strlen($search) < 1) {
            return response()->json(['results' => []]);
        }

        $karyawans = Karyawan::where('nama', 'LIKE', "%{$search}%")
            ->orWhere('no_tlp', 'LIKE', "%{$search}%")
            ->limit(10)
            ->get(['id_karyawan', 'nama', 'no_tlp']);

        return response()->json([
            'results' => $karyawans->map(fn($k) => [
                'id' => $k->id_karyawan,
                'text' => $k->nama . ' (' . $k->no_tlp . ')',
                'nama' => $k->nama,
                'no_tlp' => $k->no_tlp,
            ])
        ]);
    }

    public function export()
    {
        $karyawans = Karyawan::all();
        $filename = 'data-karyawan-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($karyawans) {
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($output, ['No', 'Nama Karyawan', 'No HP', 'Alamat', 'Status']);

            foreach ($karyawans as $i => $k) {
                fputcsv($output, [$i + 1, $k->nama, $k->no_tlp, $k->alamat, $k->status]);
            }

            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }
}
