<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ParkirController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MidtransChargeController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\penjagaController;
use App\Http\Controllers\RiwayatController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UsersController::class, 'register']);
Route::post('/login', [UsersController::class, 'login']);

// 🔒 Route yang butuh Auth
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UsersController::class, 'logout']);

    Route::post('/penjaga/update', [penjagaController::class, 'updatePenjaga']);
    Route::put('/penjaga/update', [penjagaController::class, 'updatePenjaga']);
    Route::get('/penjaga/profile', [penjagaController::class, 'profilePenjaga']);

    Route::get('/pengguna/profile', [penggunaController::class, 'profile']);
    Route::put('/pengguna/update', [penggunaController::class, 'update']);
    Route::post('/pengguna/update', [penggunaController::class, 'update']); 

    Route::get('/pengguna/statistik', [RiwayatController::class, 'getStatistikByUser']);
    Route::put('/pengguna/payment-method', [PenggunaController::class, 'updateLastPaymentMethod']);
    Route::get('/pengguna/payment-method', [PenggunaController::class, 'getLastPaymentMethod']);
    Route::post('/midtrans/generate-token', [MidtransController::class, 'generateSnapToken']);
    Route::get('/pendapatan/hari-ini', [RiwayatController::class, 'getPendapatanHariIni']);
    Route::get('/penjaga/statistik', [ParkirController::class, 'getStatistikHariIni']);
    // ✅ GET Status Pembayaran yang kamu minta
    Route::get('/get-status-pembayaran', [MidtransController::class, 'getStatusPembayaran']);
    
    // ✅ TAMBAHAN: Routes untuk fitur foto penjaga
    Route::post('/penjaga/upload-foto', [penjagaController::class, 'uploadFoto']);
    Route::delete('/penjaga/hapus-foto', [penjagaController::class, 'hapusFoto']);
    Route::get('/penjaga/foto', [penjagaController::class, 'getFoto']);
});

// Parkir
Route::post('/parkir', [ParkirController::class, 'store']);
Route::get('/parkir', [ParkirController::class, 'index']);
Route::get('/parkir/aktif', [ParkirController::class, 'getParkirBelumBayar']);
Route::middleware('auth:sanctum')->delete('/user', [UsersController::class, 'destroyUser']);

// Midtrans Callback
Route::post('/midtrans/callback', [MidtransController::class, 'midtransCallback']);

// Riwayat
Route::post('/riwayat/store', [RiwayatController::class, 'store']);
Route::get('/riwayat/user/{id}', [RiwayatController::class, 'getByUser']);

// Rapihkan Snap Token (hindari dobel)
Route::post('/snap-token', [MidtransController::class, 'generateSnapToken']);
Route::post('/generate-snap', [MidtransController::class, 'generateSnapToken']);