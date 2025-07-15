<?php

namespace App\Http\Controllers;

use App\Models\Parkir;
use App\Models\User;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use App\Models\RiwayatPembayaran;
use Illuminate\Support\Facades\Log;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function midtransCallback(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Ambil data dari Midtrans atau testing manual
        if ($request->has('order_id')) {
            $order_id = $request->order_id;
            $transaction = $request->transaction_status;
            $payment_type = $request->payment_type ?? null;
        } else {
            $notification = new Notification();
            $order_id = $notification->order_id;
            $transaction = $notification->transaction_status;
            $payment_type = $notification->payment_type ?? null;
        }

        Log::info('MIDTRANS CALLBACK', [
            'order_id' => $order_id,
            'transaction_status' => $transaction,
            'payment_type' => $payment_type
        ]);

        // Update status parkir
        $parkir = Parkir::where('order_id', $order_id)->first();
        if ($parkir && in_array($transaction, ['capture', 'settlement'])) {
            $parkir->status = 'sudah_bayar';
            $parkir->save();
        }

        // Update status riwayat pembayaran
        $riwayat = RiwayatPembayaran::where('order_id', $order_id)->first();
        if ($riwayat) {
            $riwayat->status = match ($transaction) {
                'settlement', 'capture' => 'Selesai',
                'pending' => 'Menunggu',
                'deny', 'cancel', 'expire' => 'Gagal',
                default => $riwayat->status,
            };
            $riwayat->save();
        }

        // Simpan metode pembayaran terakhir ke tabel pengguna jika role-nya "pengguna"
        if ($parkir && $parkir->user_id && $payment_type) {
            $user = User::find($parkir->user_id);
            if ($user && $user->role === 'pengguna') {
                $pengguna = $user->pengguna; // relasi one-to-one
                if ($pengguna) {
                    $pengguna->last_payment_method = $payment_type;
                    $pengguna->save();
                }
            }
        }

        return response()->json(['message' => 'Callback processed']);
    }

public function generateSnapToken(Request $request)
{
    $request->validate([
        'order_id' => 'required|string',
        'total_bayar' => 'required|numeric', // Dikirim dari Android
    ]);

    $parkir = Parkir::where('order_id', $request->order_id)->first();

    if (!$parkir) {
        return response()->json(['message' => 'Data parkir tidak ditemukan'], 404);
    }

    // Hapus Snap Token lama jika status belum bayar
    if ($parkir->status === 'belum_bayar' && $parkir->snap_token) {
        $parkir->snap_token = null;
        $parkir->save();
    }

    // Midtrans Config
    \Midtrans\Config::$serverKey = config('midtrans.server_key');
    \Midtrans\Config::$isProduction = config('midtrans.is_production');
    \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
    \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

    $user = \App\Models\User::find($parkir->user_id);
    $pengguna = $user?->pengguna;

    $params = [
        'transaction_details' => [
            'order_id' => $parkir->order_id,
            'gross_amount' => $request->total_bayar,
        ],
        'customer_details' => [
            'first_name' => 'User',
            'email' => 'user@example.com',
        ],
    ];

    if ($pengguna && $pengguna->last_payment_method) {
        $params['payment_method_options'] = [
            $pengguna->last_payment_method => [
                'preferred' => true
            ]
        ];
    }

    try {
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $parkir->snap_token = $snapToken;
        $parkir->save();

        return response()->json([
            'snap_token' => $snapToken,
            'total_bayar' => $request->total_bayar,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Gagal generate Snap Token',
            'error' => $e->getMessage()
        ], 500);
    }
}




}