<?php

namespace App\Http\Controllers;

use App\Models\Produk;

class WelcomeController extends Controller
{
    public function index()
    {
        $produks = Produk::where('status', 'Aktif')
            ->withCount('detailPesanans')
            ->orderByDesc('detail_pesanans_count')
            ->limit(6)
            ->get();

        return view('welcome', compact('produks'));
    }
}
