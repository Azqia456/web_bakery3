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
Route::apiResource('pelanggans', App\Http\Controllers\PelangganController::class);
Route::apiResource('karyawans', App\Http\Controllers\KaryawanController::class);
Route::apiResource('produks', App\Http\Controllers\ProdukController::class);
Route::apiResource('pesanans', App\Http\Controllers\PesananController::class);
Route::apiResource('pembayarans', App\Http\Controllers\PembayaranController::class);

Route::get('detail-pesanans', [App\Http\Controllers\DetailPesananController::class, 'index']);
Route::post('detail-pesanans', [App\Http\Controllers\DetailPesananController::class, 'store']);
Route::get('detail-pesanans/{id_pesanan}/{id_produk}', [App\Http\Controllers\DetailPesananController::class, 'show']);
Route::put('detail-pesanans/{id_pesanan}/{id_produk}', [App\Http\Controllers\DetailPesananController::class, 'update']);
Route::delete('detail-pesanans/{id_pesanan}/{id_produk}', [App\Http\Controllers\DetailPesananController::class, 'destroy']);
