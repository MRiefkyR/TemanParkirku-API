<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthdenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\SampahController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParkirController;
use App\Http\Controllers\penjagaController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\UsersController;
use App\Models\Penjaga;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {   
    Route::resource('pengguna', PenggunaController::class);
    Route::resource('penjaga', penjagaController::class);
    Route::resource('riwayatPembayaran', RiwayatController::class);
    Route::resource('parkir', ParkirController::class); // <- Tambahan CRUD Parkir
    Route::resource('user', UsersController::class);
});

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/update-password', [PasswordController::class, 'updatePassword'])->name('password.update');

    // ... other authenticated routes ...
});


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/registered-users-count', [DashboardController::class, 'getRegisteredUsersCount'])->name('registered-users-count');
Route::get('/dashboard-data', [DashboardController::class, 'getWasteData'])->name('dashboard-data');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});



require __DIR__.'/auth.php';
    