<?php

namespace App\Http\Controllers;

use App\Models\Parkir;
use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\Penjaga;
use App\Models\Sampah;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with total waste entries.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $totalWasteEntries = Penjaga::count();
        $registeredUsersCount = Pengguna::count();
        return view('dashboard', compact('totalWasteEntries', 'registeredUsersCount'));
    }

    /**
     * Get the count of registered users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRegisteredUsersCount()
    {
        $registeredUsersCount = Pengguna::count();
        return response()->json(['count' => $registeredUsersCount]);
    }

    /**
     * Get dashboard data including total waste entries and other statistics.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDashboardData()
    {
        $totalWasteEntries = Penjaga::count();
        $registeredUsersCount = Pengguna::count();
        
        // Add more statistics as needed
        $latestWasteEntries = Parkir::latest()->take(5)->get();
        
        return response()->json([
            'totalWasteEntries' => $totalWasteEntries,
            'registeredUsersCount' => $registeredUsersCount,
            'latestWasteEntries' => $latestWasteEntries,
            // Add more data as needed
        ]);
    }
}
