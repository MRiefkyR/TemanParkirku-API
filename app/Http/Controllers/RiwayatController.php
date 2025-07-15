<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPembayaran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function store(Request $request)
    {
        $riwayat = RiwayatPembayaran::create($request->all());
        return response()->json(['success' => true, 'data' => $riwayat]);
    }

    public function getByUser($id)
    {
        $riwayat = RiwayatPembayaran::where('user_id', $id)->orderBy('id', 'desc')->get();
        return response()->json($riwayat);
    }

   public function getPendapatanHariIni()
    {
        $today = Carbon::today()->toDateString(); // Format: 'Y-m-d'

        $totalPendapatan = RiwayatPembayaran::whereDate('tanggal', $today)
            ->sum('nominal');

        return response()->json([
            'success' => true,
            'total_pendapatan' => $totalPendapatan
        ]);
    }

    public function getStatistikByUser(Request $request)
{
    $user = $request->user(); // dari token login

    $totalParkir = RiwayatPembayaran::where('user_id', $user->id)->count();
    $totalBayar = RiwayatPembayaran::where('user_id', $user->id)->sum('nominal');

    return response()->json([
        'status' => 'success',
        'data' => [
            'total_parkir' => $totalParkir,
            'total_bayar' => $totalBayar
        ]
    ]);
}

    //ADMIN WEB
    public function index()
    {
        $riwayat = RiwayatPembayaran::with('user')->orderBy('id', 'desc')->get();
        return view('riwayatPembayaran.index', compact('riwayat'));
    }

}
