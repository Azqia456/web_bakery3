<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('users', App\Http\Controllers\UserController::class);
Route::get('pelanggans-autocomplete', [App\Http\Controllers\PelangganController::class, 'autocomplete']);
Route::post('pelanggans/find-or-create', [App\Http\Controllers\PelangganController::class, 'findOrCreate']);
Route::get('pelanggans-stats', [App\Http\Controllers\PelangganController::class, 'stats']);
Route::apiResource('karyawans', App\Http\Controllers\KaryawanController::class);
Route::apiResource('produks', App\Http\Controllers\ProdukController::class);
Route::apiResource('pesanans', App\Http\Controllers\PesananController::class);
Route::apiResource('pembayarans', App\Http\Controllers\PembayaranController::class);

Route::get('detail-pesanans', [App\Http\Controllers\DetailPesananController::class, 'index']);
Route::post('detail-pesanans', [App\Http\Controllers\DetailPesananController::class, 'store']);
Route::get('detail-pesanans/{id_pesanan}/{id_produk}', [App\Http\Controllers\DetailPesananController::class, 'show']);
Route::put('detail-pesanans/{id_pesanan}/{id_produk}', [App\Http\Controllers\DetailPesananController::class, 'update']);
Route::delete('detail-pesanans/{id_pesanan}/{id_produk}', [App\Http\Controllers\DetailPesananController::class, 'destroy']);

// Pesanan Offline Routes - dengan sinkronisasi otomatis ke database
Route::prefix('pesanan-offline')->group(function () {
    Route::get('/', [App\Http\Controllers\PesananOfflineController::class, 'index']);
    Route::post('/', [App\Http\Controllers\PesananOfflineController::class, 'store']);
    Route::put('/{id_pesanan}', [App\Http\Controllers\PesananOfflineController::class, 'update']);
    Route::delete('/{id_pesanan}', [App\Http\Controllers\PesananOfflineController::class, 'destroy']);
    Route::post('/{id_pesanan}/verify', [App\Http\Controllers\PesananOfflineController::class, 'verifyPayment']);
    Route::get('/type/{type}', [App\Http\Controllers\PesananOfflineController::class, 'getByType']);
});

