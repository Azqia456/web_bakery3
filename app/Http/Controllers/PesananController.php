<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function view()
    {
        return view('pesanan');
    }

    public function pelangganView()
    {
        return view('dashboard.pesanan-pelanggan');
    }

    public function index()
    {
        return Pesanan::with(['pelanggan', 'karyawan', 'detailPesanans', 'pembayarans'])->get();
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

        return Pesanan::create($validated);
    }

    public function show($id_pesanan)
    {
        return Pesanan::with(['pelanggan', 'karyawan', 'detailPesanans', 'pembayarans'])
            ->findOrFail($id_pesanan);
    }

    public function update(Request $request, $id_pesanan)
    {
        $pesanan = Pesanan::findOrFail($id_pesanan);

        $validated = $request->validate([
            'id_pelanggan' => 'integer|exists:pelanggans,id_pelanggan',
            'id_karyawan' => 'integer|exists:karyawans,id_karyawan',
            'tgl_pesan' => 'date',
            'status_bayar' => 'in:belum_lunas,lunas',
            'total_bayar' => 'numeric|min:0',
        ]);

        $pesanan->update($validated);

        return $pesanan;
    }

    public function destroy($id_pesanan)
    {
        $pesanan = Pesanan::findOrFail($id_pesanan);
        $pesanan->delete();

        return response()->noContent();
    }

    public function offline()
    {
        return view('pesanan-offline');
    }

    public function online()
    {
        return view('pesanan-online');
    }
}
