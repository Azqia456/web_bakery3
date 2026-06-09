<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Services\PesananSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PesananController extends Controller
{
    public function view()
    {
        return view('pesanan');
    }

    public function pelangganView()
    {
        $user = Auth::user();
        $pelanggan = \App\Models\Pelanggan::where('id_user', $user->id_user)->first();

        if (!$pelanggan) {
            $pelanggan = \App\Models\Pelanggan::create([
                'id_user' => $user->id_user,
                'nama' => $user->username,
                'email' => $user->email,
                'no_tlp' => $user->no_telpon,
                'status' => 'Online',
            ]);
        }

        $pesanans = Pesanan::with(['pelanggan', 'karyawan', 'detailPesanans', 'detailPesanans.produk'])
            ->where('id_pelanggan', $pelanggan->id_pelanggan)
            ->orderBy('tgl_pesan', 'desc')
            ->get();

        return view('dashboard.pesanan-pelanggan', compact('pelanggan', 'pesanans'));
    }

    public function index()
    {
        $user = Auth::user();

        if ($user && $user->role === 'pelanggan') {
            $pelanggan = \App\Models\Pelanggan::where('id_user', $user->id_user)->first();
            if ($pelanggan) {
                return Pesanan::with(['pelanggan', 'karyawan', 'detailPesanans', 'detailPesanans.produk'])
                    ->where('id_pelanggan', $pelanggan->id_pelanggan)
                    ->orderBy('tgl_pesan', 'desc')
                    ->get();
            }
            return [];
        }

        return PesananSyncService::getAllPesanan();
    }

    public function pelangganOrders()
    {
        return Pesanan::with(['pelanggan', 'karyawan', 'detailPesanans', 'detailPesanans.produk'])
            ->where('id_pelanggan', \App\Models\Pelanggan::where('id_user', Auth::user()->id_user)->first()->id_pelanggan)
            ->orderBy('tgl_pesan', 'desc')
            ->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pelanggan' => 'required|integer|exists:pelanggans,id_pelanggan',
            'id_karyawan' => 'required|integer|exists:karyawans,id_karyawan',
            'tgl_pesan' => 'required|date',
            'status_bayar' => 'required|in:belum_lunas,lunas',
            'total_bayar' => 'required|numeric|min:0',
        ]);

        // Gunakan service untuk sinkronisasi pesanan
        return PesananSyncService::updatePesanan(null, $validated);
    }

    public function show($id_pesanan)
    {
        $pesanan = Pesanan::with(['pelanggan', 'karyawan', 'detailPesanans.produk', 'pembayarans'])
            ->findOrFail($id_pesanan);
        
        return response()->json($pesanan);
    }

    public function update(Request $request, $id_pesanan)
    {
        $validated = $request->validate([
            'id_pelanggan' => 'integer|exists:pelanggans,id_pelanggan',
            'id_karyawan' => 'integer|exists:karyawans,id_karyawan',
            'tgl_pesan' => 'date',
            'status_bayar' => 'in:belum_lunas,lunas',
            'status_pembayaran' => 'in:lunas,menunggu_verifikasi,belum_bayar',
            'status_pesanan' => 'in:menunggu_konfirmasi,diproses,siap_diambil,dikirim,selesai',
            'total_bayar' => 'numeric|min:0',
            'products' => 'array',
        ]);

        // Gunakan service untuk update dengan sinkronisasi
        return PesananSyncService::updatePesanan($id_pesanan, $validated);
    }

    public function destroy($id_pesanan)
    {
        // Gunakan service untuk hapus dengan sinkronisasi
        PesananSyncService::deletePesanan($id_pesanan);

        return response()->noContent();
    }

    public function offline(Request $request)
    {
        // Query pesanan karyawan (offline, id_pelanggan null)
        $queryKaryawan = Pesanan::with(['karyawan', 'detailPesanans.produk'])
            ->where('sumber_pesanan', 'offline')
            ->whereNull('id_pelanggan');

        // Query pesanan pelanggan (offline, id_pelanggan not null)
        $queryPelanggan = Pesanan::with(['pelanggan', 'detailPesanans.produk'])
            ->where('sumber_pesanan', 'offline')
            ->whereNotNull('id_pelanggan');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $queryKaryawan->where(function ($q) use ($search) {
                $q->where('id_pesanan', 'like', "%{$search}%")
                  ->orWhereHas('karyawan', function ($kq) use ($search) {
                      $kq->where('nama', 'like', "%{$search}%");
                  });
            });
            $queryPelanggan->where(function ($q) use ($search) {
                $q->where('id_pesanan', 'like', "%{$search}%")
                  ->orWhereHas('pelanggan', function ($pq) use ($search) {
                      $pq->where('nama', 'like', "%{$search}%")
                         ->orWhere('no_tlp', 'like', "%{$search}%");
                  });
            });
        }

        // Filter status_bayar
        if ($request->filled('status')) {
            $queryKaryawan->where('status_bayar', $request->status);
            $queryPelanggan->where('status_bayar', $request->status);
        }

        $pesananKaryawan = $queryKaryawan->orderBy('tgl_pesan', 'desc')->get();
        $pesananPelanggan = $queryPelanggan->orderBy('tgl_pesan', 'desc')->get();

        // Map to JS-friendly arrays
        $karyawanItems = $pesananKaryawan->map(function ($p) {
            return [
                'id' => 'K-' . $p->id_pesanan,
                'id_pesanan' => $p->id_pesanan,
                'id_karyawan' => $p->id_karyawan,
                'nama' => $p->karyawan->nama ?? '-',
                'status' => $p->status_bayar === 'lunas' ? 'sudah_setor' : 'belum_setor',
                'status_bayar' => $p->status_bayar,
                'tanggal_pesan' => $p->tgl_pesan->format('Y-m-d'),
                'tanggal_pickup' => $p->tgl_pesan->format('Y-m-d'),
                'tanggal_setor' => $p->status_bayar === 'lunas' ? $p->tgl_pesan->format('Y-m-d') : null,
                'total' => (float) $p->total_bayar,
                'produk' => $p->detailPesanans->map(function ($d) {
                    return [
                        'id_produk' => $d->id_produk,
                        'nama' => $d->produk->nama_produk ?? '-',
                        'harga' => (float) ($d->produk->harga_produk ?? 0),
                        'qty' => (int) $d->jumlah_pesan,
                    ];
                })->values()->all(),
            ];
        })->values()->all();

        $pelangganItems = $pesananPelanggan->map(function ($p) {
            return [
                'id' => 'P-' . $p->id_pesanan,
                'id_pesanan' => $p->id_pesanan,
                'id_pelanggan' => $p->id_pelanggan,
                'nama' => $p->pelanggan->nama ?? '-',
                'no_hp' => $p->pelanggan->no_tlp ?? '-',
                'status' => $p->status_bayar === 'lunas' ? 'selesai' : 'diproses',
                'status_bayar' => $p->status_bayar,
                'tgl_transaksi' => $p->tgl_pesan->format('Y-m-d'),
                'metode_pengambilan' => $p->metode_pengambilan ?? 'pickup',
                'metode_pembayaran' => $p->metode_pembayaran ?? 'cash',
                'total' => (float) $p->total_bayar,
                'alamat_delivery' => $p->alamat_delivery,
                'tanggal_delivery' => $p->tgl_delivery ? $p->tgl_delivery->format('Y-m-d') : null,
                'tanggal_pickup' => $p->tgl_pesan->format('Y-m-d'),
                'produk' => $p->detailPesanans->map(function ($d) {
                    return [
                        'id_produk' => $d->id_produk,
                        'nama' => $d->produk->nama_produk ?? '-',
                        'harga' => (float) ($d->produk->harga_produk ?? 0),
                        'qty' => (int) $d->jumlah_pesan,
                    ];
                })->values()->all(),
            ];
        })->values()->all();

        // Stats
        $stats = [
            'total' => Pesanan::where('sumber_pesanan', 'offline')->count(),
            'diproses' => Pesanan::where('sumber_pesanan', 'offline')->where('status_bayar', 'belum_lunas')->count(),
            'selesai' => Pesanan::where('sumber_pesanan', 'offline')->where('status_bayar', 'lunas')->count(),
        ];

        return view('pesanan-offline', compact('karyawanItems', 'pelangganItems', 'stats'))->with([
            'pageTitle' => 'Pesanan Offline',
            'totalNotifikasi' => $stats['diproses'] ?? 0
        ]);
    }

    public function online(Request $request)
    {
        $query = Pesanan::with(['pelanggan', 'detailPesanans.produk'])
            ->where('sumber_pesanan', 'online');

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('tgl_pesan', $request->date);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_pesanan', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id_pesanan', 'like', "%{$search}%")
                  ->orWhereHas('pelanggan', function ($pq) use ($search) {
                      $pq->where('nama', 'like', "%{$search}%")
                         ->orWhere('no_tlp', 'like', "%{$search}%");
                  })
                  ->orWhereHas('detailPesanans.produk', function ($pq) use ($search) {
                      $pq->where('nama_produk', 'like', "%{$search}%");
                  });
            });
        }

        $pesanans = $query->orderBy('tgl_pesan', 'desc')->paginate(10)->withQueryString();

        // Calculate stats
        $stats = [
            'semua' => Pesanan::where('sumber_pesanan', 'online')->count(),
            'menunggu_konfirmasi' => Pesanan::where('sumber_pesanan', 'online')->where('status_pesanan', 'menunggu_konfirmasi')->count(),
            'diproses' => Pesanan::where('sumber_pesanan', 'online')->where('status_pesanan', 'diproses')->count(),
            'siap_diambil' => Pesanan::where('sumber_pesanan', 'online')->where('status_pesanan', 'siap_diambil')->count(),
            'dikirim' => Pesanan::where('sumber_pesanan', 'online')->where('status_pesanan', 'dikirim')->count(),
            'selesai' => Pesanan::where('sumber_pesanan', 'online')->where('status_pesanan', 'selesai')->count(),
        ];

        return view('pesanan-online', compact('pesanans', 'stats'))->with([
            'pageTitle' => 'Pesanan Online',
            'totalNotifikasi' => $stats['menunggu_konfirmasi'] ?? 0
        ]);
    }

    public function submitOrder($id_pesanan)
    {
        $pesanan = Pesanan::findOrFail($id_pesanan);

        // Advance order status
        $statusFlow = [
            'menunggu_konfirmasi' => 'diproses',
            'diproses' => 'siap_diambil',
            'siap_diambil' => $pesanan->metode_pengambilan === 'delivery' ? 'dikirim' : 'selesai',
            'dikirim' => 'selesai',
            'selesai' => 'selesai',
        ];

        $currentStatus = $pesanan->status_pesanan ?: 'menunggu_konfirmasi';
        $newStatus = $statusFlow[$currentStatus] ?? 'selesai';

        $pesanan->update(['status_pesanan' => $newStatus]);

        return response()->json([
            'success' => true,
            'message' => 'Status pesanan berhasil diperbarui.',
            'status_pesanan' => $newStatus,
        ]);
    }

    public function confirmPaymentProof(Request $request)
    {
        $validated = $request->validate([
            'order_reference' => 'nullable|string|max:100',
            'nama_pengirim' => 'nullable|string|max:255',
            'bank_pengirim' => 'nullable|string|max:100',
            'nominal_transfer' => 'nullable|numeric|min:0',
            'bukti_transfer' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'catatan_pembayaran' => 'nullable|string|max:1000',
            'items' => 'nullable|string',
        ]);

        $customer = Auth::user()?->pelanggan;

        if (! $customer) {
            return response()->json([
                'success' => false,
                'message' => 'Data pelanggan tidak ditemukan untuk akun ini.',
            ], 422);
        }

        $items = json_decode($validated['items'] ?? '[]', true);
        $expectedTotal = (int) round((float) ($validated['nominal_transfer'] ?? 0));
        $products = [];

        if (is_array($items)) {
            foreach ($items as $item) {
                $productId = (int) ($item['id_produk'] ?? 0);
                $quantity = max(1, (int) ($item['quantity'] ?? 1));

                if ($productId <= 0) {
                    continue;
                }

                $products[] = [
                    'id_produk' => $productId,
                    'jumlah_pesan' => $quantity,
                ];
            }
        }

        $buktiPath = $request->file('bukti_transfer')->store('bukti-transfer', 'public');
        $catatan = trim(implode(' | ', array_filter([
            'Referensi: ' . ($validated['order_reference'] ?? '-'),
            'Pengirim: ' . ($validated['nama_pengirim'] ?? '-'),
            'Bank: ' . ($validated['bank_pengirim'] ?? '-'),
            'Nominal: ' . ($validated['nominal_transfer'] ?? 0),
            $validated['catatan_pembayaran'] ?? null,
        ])));

        $pesanan = PesananSyncService::createPesananPelanggan([
            'id_pelanggan' => $customer->id_pelanggan,
            'nama_pelanggan' => $customer->nama,
            'no_tlp' => $customer->no_tlp ?? $customer->no_hp ?? null,
            'id_karyawan' => null,
            'tgl_pesan' => now(),
            'sumber_pesanan' => 'online',
            'metode_pengambilan' => 'pickup',
            'metode_pembayaran' => 'transfer',
            'status_pembayaran' => 'menunggu_verifikasi',
            'bukti_transfer' => $buktiPath,
            'catatan_pesanan' => $catatan,
            'status_bayar' => 'belum_lunas',
            'total_bayar' => $expectedTotal,
            'products' => $products,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bukti pembayaran berhasil dikirim. Pesanan menunggu verifikasi.',
            'data' => [
                'id_pesanan' => $pesanan->id_pesanan,
                'total_bayar' => $expectedTotal,
                'bukti_transfer_url' => Storage::url($buktiPath),
            ],
        ]);
    }

    public function createPelangganOrder(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'produk' => 'required|string|max:255',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $pelanggan = \App\Models\Pelanggan::where('id_user', $user->id_user)->first();

        if (!$pelanggan) {
            $pelanggan = \App\Models\Pelanggan::create([
                'id_user' => $user->id_user,
                'nama' => $user->username,
                'email' => $user->email,
                'no_tlp' => $validated['no_hp'],
                'status' => 'Online',
            ]);
        } else {
            $pelanggan->update([
                'nama' => $validated['nama'],
                'no_tlp' => $validated['no_hp'],
            ]);
        }

        $produk = \App\Models\Produk::where('nama_produk', 'like', '%' . $validated['produk'] . '%')->first();

        if (!$produk) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan.'], 422);
        }

        $pesanan = PesananSyncService::createPesananPelanggan([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'id_karyawan' => null,
            'tgl_pesan' => now(),
            'sumber_pesanan' => 'online',
            'metode_pengambilan' => 'pickup',
            'metode_pembayaran' => 'transfer',
            'status_pembayaran' => 'belum_bayar',
            'catatan_pesanan' => $validated['catatan'] ?? null,
            'status_bayar' => 'belum_lunas',
            'total_bayar' => $produk->harga_produk ?? 0,
            'products' => [
                ['id_produk' => $produk->id_produk, 'jumlah_pesan' => 1],
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat!',
            'data' => ['id_pesanan' => $pesanan->id_pesanan],
        ]);
    }
}
