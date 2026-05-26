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

    /**
     * Autocomplete search untuk offline order form
     */
    public function autocomplete(Request $request)
    {
        $query = $request->query('q', '');
        
        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $results = Pelanggan::where('nama', 'LIKE', "%{$query}%")
            ->orWhere('no_tlp', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get()
            ->map(function ($customer) {
                return [
                    'id' => $customer->id_pelanggan,
                    'text' => $customer->nama . ' (' . $customer->no_tlp . ')',
                    'nama' => $customer->nama,
                    'no_tlp' => $customer->no_tlp,
                    'email' => $customer->email,
                    'status' => $customer->status ?? 'Offline',
                ];
            });

        return response()->json(['results' => $results]);
    }

    /**
     * Find or create customer for offline orders
     */
    public function findOrCreate(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'no_tlp' => 'required|string',
            'email' => 'nullable|email',
            'alamat' => 'required|string',
        ]);

        // Try to find by phone number (unique identifier)
        $pelanggan = Pelanggan::where('no_tlp', $validated['no_tlp'])->first();

        if ($pelanggan) {
            // Customer exists
            return response()->json([
                'success' => true,
                'message' => 'Pelanggan ditemukan',
                'pelanggan' => [
                    'id_pelanggan' => $pelanggan->id_pelanggan,
                    'nama' => $pelanggan->nama,
                    'no_tlp' => $pelanggan->no_tlp,
                    'email' => $pelanggan->email,
                    'status' => $pelanggan->status ?? 'Offline',
                ],
                'created' => false,
            ]);
        }

        // Create new customer
        $pelanggan = Pelanggan::create([
            'nama' => $validated['nama'],
            'no_tlp' => $validated['no_tlp'],
            'email' => $validated['email'] ?? null,
            'alamat' => $validated['alamat'],
            'status' => 'Offline',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pelanggan baru berhasil dibuat',
            'pelanggan' => [
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'nama' => $pelanggan->nama,
                'no_tlp' => $pelanggan->no_tlp,
                'email' => $pelanggan->email,
                'status' => $pelanggan->status ?? 'Offline',
            ],
            'created' => true,
        ], 201);
    }

    /**
     * Get customer statistics for dashboard sync
     */
    public function stats()
    {
        $totalPelanggan = Pelanggan::count();
        $pelangganOnline = Pelanggan::where('status', 'Online')->count();
        $pelangganOffline = Pelanggan::where('status', 'Offline')->count();

        return response()->json([
            'total_pelanggan' => $totalPelanggan,
            'pelanggan_online' => $pelangganOnline,
            'pelanggan_offline' => $pelangganOffline,
            'total_pesanan_hari_ini' => 0, // Will be updated from pesanan table
            'total_pesanan_bulan_ini' => 0, // Will be updated from pesanan table
        ]);
    }
}
