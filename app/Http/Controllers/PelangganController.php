<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PelangganController extends Controller
{
    public function index()
    {
        return Pelanggan::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_tlp' => 'required|string|max:50|unique:pelanggans,no_tlp',
            'email' => 'nullable|email|unique:pelanggans,email',
            'alamat' => 'required|string',
            'status' => 'required|in:Online,Offline',
        ]);

        $validated['id_user'] = auth()->id();
        $pelanggan = Pelanggan::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pelanggan berhasil ditambahkan',
            'pelanggan' => $pelanggan,
        ]);
    }

    public function show($id_pelanggan)
    {
        $pelanggan = Pelanggan::with('pesanans')->findOrFail($id_pelanggan);

        return response()->json([
            'pelanggan' => $pelanggan,
            'pesanans' => $pelanggan->pesanans,
        ]);
    }

    public function update(Request $request, $id_pelanggan)
    {
        $pelanggan = Pelanggan::findOrFail($id_pelanggan);

        $validated = $request->validate([
            'nama' => 'string|max:255',
            'no_tlp' => 'string|max:50|unique:pelanggans,no_tlp,' . $id_pelanggan . ',id_pelanggan',
            'email' => 'nullable|email|unique:pelanggans,email,' . $id_pelanggan . ',id_pelanggan',
            'alamat' => 'string',
            'status' => 'in:Online,Offline',
        ]);

        $pelanggan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pelanggan berhasil diperbarui',
            'pelanggan' => $pelanggan,
        ]);
    }

    public function destroy($id_pelanggan)
    {
        $pelanggan = Pelanggan::findOrFail($id_pelanggan);

        $pesananCount = $pelanggan->pesanans()->count();
        if ($pesananCount > 0) {
            return response()->json([
                'success' => false,
                'message' => "Tidak dapat menghapus pelanggan yang memiliki {$pesananCount} pesanan. Hapus pesanan terlebih dahulu.",
            ], 422);
        }

        $pelanggan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pelanggan berhasil dihapus',
        ]);
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
                    'text' => $customer->nama . '_' . $customer->no_tlp,
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

        // Create new customer with user account
        $username = Str::slug($validated['nama']) . '_' . substr($validated['no_tlp'], -4);
        $baseUsername = $username;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        $userEmail = $validated['email'] ?? $username . '@offline.threedbakery.com';
        $user = User::create([
            'username' => $username,
            'email' => $userEmail,
            'password' => Hash::make('password'),
            'role' => 'pelanggan',
            'no_telpon' => $validated['no_tlp'],
            'alamat' => $validated['alamat'],
        ]);

        $pelanggan = Pelanggan::create([
            'nama' => $validated['nama'],
            'no_tlp' => $validated['no_tlp'],
            'email' => $validated['email'] ?? null,
            'alamat' => $validated['alamat'],
            'status' => 'Offline',
            'id_user' => $user->id_user,
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
