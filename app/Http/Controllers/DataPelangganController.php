<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DataPelangganController extends Controller
{
    /**
     * Display the data pelanggan page with search, filter, and pagination
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $status = $request->get('status', '');
        $perPage = $request->get('per_page', 10);

        $query = Pelanggan::with('pesanans');

        // Search by name or phone number
        if ($search) {
            $query->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('no_tlp', 'LIKE', "%{$search}%");
        }

        // Filter by status
        if ($status && in_array($status, ['Online', 'Offline'])) {
            $query->where('status', $status);
        }

        $pelanggans = $query->paginate($perPage);

        // Add computed attributes for each customer
        $pelanggans->each(function ($pelanggan) {
            $pelanggan->total_pesanan = $pelanggan->pesanans()->count();
            $pelanggan->terakhir_pesan = $pelanggan->pesanans()->latest('tgl_pesan')->first()?->tgl_pesan;
        });

        // Get statistics
        $stats = [
            'total_pelanggan' => Pelanggan::count(),
            'pelanggan_online' => Pelanggan::where('status', 'Online')->count(),
            'pelanggan_offline' => Pelanggan::where('status', 'Offline')->count(),
            'total_pesanan_hari_ini' => Pesanan::whereDate('tgl_pesan', Carbon::today())->count(),
        ];

        if ($request->ajax()) {
            return response()->json([
                'data' => $pelanggans->items(),
                'pagination' => [
                    'current_page' => $pelanggans->currentPage(),
                    'last_page' => $pelanggans->lastPage(),
                    'per_page' => $pelanggans->perPage(),
                    'total' => $pelanggans->total(),
                    'from' => $pelanggans->firstItem(),
                    'to' => $pelanggans->lastItem(),
                ],
                'stats' => $stats,
            ]);
        }

        return view('data-pelanggan', compact('pelanggans', 'stats', 'search', 'status', 'perPage'));
    }

    /**
     * Get customer details for viewing
     */
    public function show($id_pelanggan)
    {
        $pelanggan = Pelanggan::with('pesanans')->findOrFail($id_pelanggan);
        
        $pelanggan->total_pesanan = $pelanggan->pesanans()->count();
        $pelanggan->terakhir_pesan = $pelanggan->pesanans()->latest('tgl_pesan')->first()?->tgl_pesan;

        // Get order history
        $pesanans = $pelanggan->pesanans()
            ->with('detailPesanans')
            ->latest('tgl_pesan')
            ->get();

        if (request()->ajax()) {
            return response()->json([
                'pelanggan' => $pelanggan,
                'pesanans' => $pesanans,
            ]);
        }

        return view('pelanggan.detail', compact('pelanggan', 'pesanans'));
    }

    /**
     * Store a new customer (manual addition)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_tlp' => 'required|string|max:50|unique:pelanggans,no_tlp',
            'email' => 'nullable|email|unique:pelanggans,email',
            'alamat' => 'required|string',
            'status' => 'required|in:Online,Offline',
        ]);

        $username = Str::slug($validated['nama']) . '_' . substr($validated['no_tlp'], -4);
        $baseUsername = $username;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        $userEmail = $validated['email'] ?? $username . '@offline.threedbakery.com';
        if ($validated['email']) {
            $existingUser = User::where('email', $validated['email'])->first();
            if ($existingUser) {
                $validated['id_user'] = $existingUser->id_user;
            }
        }

        if (!isset($validated['id_user'])) {
            $user = User::create([
                'username' => $username,
                'email' => $userEmail,
                'password' => Hash::make('password'),
                'role' => 'pelanggan',
                'no_telpon' => $validated['no_tlp'],
                'alamat' => $validated['alamat'],
            ]);
            $validated['id_user'] = $user->id_user;
        }

        $pelanggan = Pelanggan::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pelanggan berhasil ditambahkan',
                'pelanggan' => $pelanggan,
            ]);
        }

        return redirect()->route('data-pelanggan')->with('success', 'Pelanggan berhasil ditambahkan');
    }

    /**
     * Update customer data
     */
    public function update(Request $request, $id_pelanggan)
    {
        $pelanggan = Pelanggan::findOrFail($id_pelanggan);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_tlp' => 'required|string|max:50|unique:pelanggans,no_tlp,' . $id_pelanggan . ',id_pelanggan',
            'email' => 'nullable|email|unique:pelanggans,email,' . $id_pelanggan . ',id_pelanggan',
            'alamat' => 'required|string',
            'status' => 'required|in:Online,Offline',
        ]);

        $pelanggan->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pelanggan berhasil diperbarui',
                'pelanggan' => $pelanggan,
            ]);
        }

        return redirect()->route('data-pelanggan')->with('success', 'Pelanggan berhasil diperbarui');
    }

    /**
     * Delete customer
     */
    public function destroy(Request $request, $id_pelanggan)
    {
        $pelanggan = Pelanggan::findOrFail($id_pelanggan);

        // Check if customer has orders
        $pesananCount = $pelanggan->pesanans()->count();
        if ($pesananCount > 0) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => "Tidak dapat menghapus pelanggan yang memiliki {$pesananCount} pesanan. Hapus pesanan terlebih dahulu.",
                ], 422);
            }

            return back()->with('error', "Tidak dapat menghapus pelanggan yang memiliki {$pesananCount} pesanan. Hapus pesanan terlebih dahulu.");
        }

        $pelanggan->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pelanggan berhasil dihapus',
            ]);
        }

        return redirect()->route('data-pelanggan')->with('success', 'Pelanggan berhasil dihapus');
    }

    /**
     * Autocomplete search for customer selection in offline orders
     */
    public function autocomplete(Request $request)
    {
        $search = $request->get('q', '');

        $pelanggans = Pelanggan::where('nama', 'LIKE', "%{$search}%")
                              ->orWhere('no_tlp', 'LIKE', "%{$search}%")
                              ->limit(10)
                              ->get(['id_pelanggan', 'nama', 'no_tlp', 'email', 'alamat', 'status'])
                              ->map(function ($pelanggan) {
                                  return [
                                      'id' => $pelanggan->id_pelanggan,
                                      'text' => "{$pelanggan->nama} ({$pelanggan->no_tlp})",
                                      'nama' => $pelanggan->nama,
                                      'no_tlp' => $pelanggan->no_tlp,
                                      'email' => $pelanggan->email,
                                      'alamat' => $pelanggan->alamat,
                                      'status' => $pelanggan->status,
                                  ];
                              });

        return response()->json(['results' => $pelanggans]);
    }

    /**
     * Find or create customer for offline orders (prevents duplicates)
     */
    public function findOrCreateForOfflineOrder(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_tlp' => 'required|string|max:50',
            'email' => 'nullable|email',
            'alamat' => 'nullable|string',
        ]);

        // Check if customer already exists by phone number
        $pelanggan = Pelanggan::where('no_tlp', $validated['no_tlp'])->first();

        if ($pelanggan) {
            // Pelanggan sudah ada, gunakan yang lama
            return response()->json([
                'success' => true,
                'message' => 'Pelanggan ditemukan',
                'pelanggan' => $pelanggan,
                'created' => false,
            ]);
        }

        // Create new customer with Offline status, also create user account
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
            'alamat' => $validated['alamat'] ?? 'Offline Order',
        ]);

        $pelanggan = Pelanggan::create([
            'id_user' => $user->id_user,
            'nama' => $validated['nama'],
            'no_tlp' => $validated['no_tlp'],
            'email' => $validated['email'] ?? null,
            'alamat' => $validated['alamat'] ?? 'Offline Order',
            'status' => 'Offline',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pelanggan baru berhasil dibuat',
            'pelanggan' => $pelanggan,
            'created' => true,
        ]);
    }

    /**
     * Get dashboard statistics (for syncing with dashboard)
     */
    public function statistics()
    {
        $stats = [
            'total_pelanggan' => Pelanggan::count(),
            'pelanggan_online' => Pelanggan::where('status', 'Online')->count(),
            'pelanggan_offline' => Pelanggan::where('status', 'Offline')->count(),
            'total_pesanan_hari_ini' => Pesanan::whereDate('tgl_pesan', Carbon::today())->count(),
            'total_pesanan_bulan_ini' => Pesanan::whereMonth('tgl_pesan', Carbon::now()->month)->count(),
        ];

        return response()->json($stats);
    }
}
