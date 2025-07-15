<?php

namespace App\Http\Controllers;

use App\Models\Parkir;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParkirController extends Controller
{
   public function store(Request $request)
    {
        $request->validate([
            'no_plat' => 'required|string',
            'jam_masuk' => 'required',
            'jenis_kendaraan' => 'required',
            'tarif' => 'required|numeric',
            'order_id' => 'required|string',
        ]);

        // Konversi jam_masuk ke format lengkap Y-m-d H:i:s
        try {
            $formattedJamMasuk = Carbon::parse($request->jam_masuk)->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Format waktu tidak valid',
                'error' => $e->getMessage()
            ], 400);
        }

        $parkir = Parkir::create([
            'no_plat' => $request->no_plat,
            'jam_masuk' => $formattedJamMasuk,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'tarif' => $request->tarif,
            'order_id' => $request->order_id,
            'status' => 'belum_bayar',
        ]);

        return response()->json([
            'success' => true,
            'data' => $parkir,
            'message' => 'Data parkir berhasil ditambahkan',
        ], 201);
    }


    public function getParkirBelumBayar()
    {
        $data = Parkir::where('status', 'belum_bayar')->get();
        return response()->json($data);
    }

    public function getStatistikHariIni()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'total_parkir' => Parkir::totalHariIni(),
                'parkir_aktif' => Parkir::aktifHariIni()
            ]
        ]);
    }





    //WEB ADMIN
    public function index()
    {
        $data = Parkir::all();
        return view('parkir.index', compact('data'));
    }

    public function create()
    {
        return view('parkir.create');
    }

    public function edit($id)
    {
        $parkir = Parkir::findOrFail($id);
        return view('parkir.edit', compact('parkir'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'no_plat' => 'required|string',
            'jam_masuk' => 'required',
            'jenis_kendaraan' => 'required',
            'tarif' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $parkir = Parkir::findOrFail($id);
        $parkir->update($request->all());

        return redirect()->route('parkir.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $parkir = Parkir::findOrFail($id);
        $parkir->delete();

        return redirect()->route('parkir.index')->with('success', 'Data berhasil dihapus');
    }

}
