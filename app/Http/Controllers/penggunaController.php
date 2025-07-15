<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class penggunaController extends Controller
{
    public function update(Request $request)
    {
        try {
            // Set proper headers for JSON response
            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ];

            // Log request untuk debugging
            Log::info('Update Pengguna Request:', [
                'user_id' => auth()->id(),
                'has_file' => $request->hasFile('foto'),
                'content_type' => $request->header('Content-Type'),
                'files' => $request->allFiles(),
                'data' => $request->except(['foto'])
            ]);

            // Untuk FormUrlEncoded di PUT, parse manual input:
            if ($request->isMethod('put') && !$request->hasFile('foto')) {
                parse_str(file_get_contents("php://input"), $formData);
                $request->merge($formData);
            }

            $pengguna = Pengguna::where('user_id', auth()->id())->first();

            if (!$pengguna) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data pengguna tidak ditemukan'
                ], 404, $headers);
            }

            // Enhanced validation
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255|min:2',
                'jenis_kelamin' => 'required|in:laki-laki,perempuan',
                'alamat' => 'required|string|max:500|min:10',
                'no_hp' => 'required|string|max:20|min:10',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ], [
                'nama.required' => 'Nama wajib diisi',
                'nama.min' => 'Nama minimal 2 karakter',
                'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
                'jenis_kelamin.in' => 'Jenis kelamin tidak valid',
                'alamat.required' => 'Alamat wajib diisi',
                'alamat.min' => 'Alamat minimal 10 karakter',
                'no_hp.required' => 'Nomor HP wajib diisi',
                'no_hp.min' => 'Nomor HP minimal 10 karakter',
                'foto.image' => 'File harus berupa gambar',
                'foto.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
                'foto.max' => 'Ukuran gambar maksimal 2MB'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422, $headers);
            }

            // Handle upload foto
            $fotoPath = $pengguna->foto; // Keep existing photo if no new upload
            
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                
                // Validate file size and type
                if (!$file->isValid()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'File yang diupload tidak valid'
                    ], 400, $headers);
                }
                
                // Check file size (2MB = 2048KB)
                if ($file->getSize() > 2048 * 1024) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Ukuran file terlalu besar. Maksimal 2MB'
                    ], 413, $headers);
                }
                
                // Hapus foto lama jika ada
                if ($pengguna->foto && Storage::exists('public/' . $pengguna->foto)) {
                    Storage::delete('public/' . $pengguna->foto);
                }
                
                // Upload foto baru dengan nama yang lebih aman
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $fotoPath = $file->storeAs('pengguna/photos', $filename, 'public');
                
                Log::info('File uploaded successfully:', ['path' => $fotoPath]);
            }

            // Update tabel 'penggunas'
            $pengguna->update([
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'foto' => $fotoPath,
                'updated_at' => now()
            ]);

            // ✅ Update nama hanya di relasi 'user'
            $user = $pengguna->user; // pastikan relasi ini ada di model Pengguna
            if ($user) {
                $user->update([
                    'nama' => $request->nama,
                    'updated_at' => now()
                ]);
            }

            // Prepare response data
            $responseData = $pengguna->fresh()->load('user');
            if ($responseData->foto) {
                $responseData->foto_url = $this->getPhotoUrl($responseData->foto);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data pengguna & nama user berhasil diupdate',
                'data' => $responseData
            ], 200, $headers);

        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Database error updating pengguna:', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan database'
            ], 500, ['Content-Type' => 'application/json']);

        } catch (\Exception $e) {
            Log::error('Error updating pengguna:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengupdate data'
            ], 500, ['Content-Type' => 'application/json']);
        }
    }

    public function profile()
    {
        try {
            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ];

            $pengguna = Pengguna::with('user')->where('user_id', auth()->id())->first();

            if (!$pengguna) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data pengguna tidak ditemukan',
                ], 404, $headers);
            }

            // Tambahkan URL foto jika ada
            if ($pengguna->foto) {
                $pengguna->foto_url = $this->getPhotoUrl($pengguna->foto);
                Log::info('Photo URL generated:', ['url' => $pengguna->foto_url]);
            }

            return response()->json([
                'status' => 'success',
                'data' => $pengguna,
            ], 200, $headers);

        } catch (\Exception $e) {
            Log::error('Error getting profile:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data profil'
            ], 500, ['Content-Type' => 'application/json']);
        }
    }

    public function updateLastPaymentMethod(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string'
        ]);

        $pengguna = Pengguna::where('user_id', auth()->id())->first();

        if (!$pengguna) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pengguna tidak ditemukan'
            ]);
        }

        $pengguna->last_payment_method = $request->payment_method;
        $pengguna->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Metode pembayaran terakhir berhasil disimpan',
            'last_payment_method' => $pengguna->last_payment_method
        ]);
    }

    public function getLastPaymentMethod()
    {
        $pengguna = Pengguna::where('user_id', auth()->id())->first();

        if (!$pengguna) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pengguna tidak ditemukan'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'last_payment_method' => $pengguna->last_payment_method
        ]);
    }

    /**
     * Generate proper photo URL for API response
     */
    private function getPhotoUrl($fotoPath)
    {
        if (!$fotoPath) {
            return null;
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($fotoPath)) {
            Log::warning('Photo file not found:', ['path' => $fotoPath]);
            return null;
        }

        // Generate URL - pastikan menggunakan URL yang benar
        $url = url('storage/' . $fotoPath);
        
        // Log untuk debugging
        Log::info('Generated photo URL:', [
            'original_path' => $fotoPath,
            'full_url' => $url,
            'file_exists' => Storage::disk('public')->exists($fotoPath)
        ]);

        return $url;
    }

    //ADMIN WEB
    public function index()
    {
        try {
            $semuaPengguna = Pengguna::with('user')->get();
            
            // Tambahkan URL foto untuk setiap pengguna
            $semuaPengguna->each(function ($pengguna) {
                if ($pengguna->foto) {
                    $pengguna->foto_url = $this->getPhotoUrl($pengguna->foto);
                }
            });

            return view('pengguna.index', compact('semuaPengguna'));
        } catch (\Exception $e) {
            Log::error('Error in pengguna index:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengambil data');
        }
    }

    public function create()
    {
        return view('pengguna.create');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:100',
                'jenis_kelamin' => 'nullable|string',
                'alamat' => 'nullable|string',
                'plat_no' => 'nullable|string|max:20',
                'no_hp' => 'nullable|string|max:15',
                'last_payment_method' => 'nullable|string|max:50',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Handle upload foto
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $fotoPath = $file->storeAs('pengguna/photos', $filename, 'public');
            }

            // Buat user baru
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'pengguna',
            ]);

            // Simpan ke tabel penggunas
            $pengguna = new Pengguna([
                'user_id' => $user->id,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'plat_no' => $request->plat_no,
                'no_hp' => $request->no_hp,
                'last_payment_method' => $request->last_payment_method,
                'foto' => $fotoPath,
            ]);
            $pengguna->save();

            return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');

        } catch (\Exception $e) {
            Log::error('Error creating pengguna:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan pengguna');
        }
    }

    public function edit($id)
    {
        try {
            $pengguna = Pengguna::with('user')->findOrFail($id);
            
            // Tambahkan URL foto jika ada
            if ($pengguna->foto) {
                $pengguna->foto_url = $this->getPhotoUrl($pengguna->foto);
            }
            
            return view('pengguna.edit', compact('pengguna'));
        } catch (\Exception $e) {
            Log::error('Error in pengguna edit:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Data pengguna tidak ditemukan');
        }
    }

    public function updateAdmin(Request $request, $id)
    {
        try {
            $pengguna = Pengguna::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:100',
                'jenis_kelamin' => 'nullable|string',
                'alamat' => 'nullable|string',
                'plat_no' => 'nullable|string|max:20',
                'no_hp' => 'nullable|string|max:15',
                'last_payment_method' => 'nullable|string|max:50',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Handle upload foto
            $fotoPath = $pengguna->foto;
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($pengguna->foto && Storage::exists('public/' . $pengguna->foto)) {
                    Storage::delete('public/' . $pengguna->foto);
                }
                
                // Upload foto baru
                $file = $request->file('foto');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $fotoPath = $file->storeAs('pengguna/photos', $filename, 'public');
            }

            $pengguna->update([
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'plat_no' => $request->plat_no,
                'no_hp' => $request->no_hp,
                'last_payment_method' => $request->last_payment_method,
                'foto' => $fotoPath,
            ]);

            // Update nama di user jika perlu
            if ($pengguna->user) {
                $pengguna->user->update([
                    'nama' => $request->nama,
                    'updated_at' => now()
                ]);
            }

            return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Error updating pengguna:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data');
        }
    }

    public function destroy($id)
    {
        try {
            $pengguna = Pengguna::findOrFail($id);
            $user = $pengguna->user;
            
            // Hapus foto jika ada
            if ($pengguna->foto && Storage::exists('public/' . $pengguna->foto)) {
                Storage::delete('public/' . $pengguna->foto);
            }
            
            $pengguna->delete();
            if ($user) $user->delete();

            return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Error deleting pengguna:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus pengguna');
        }
    }
}