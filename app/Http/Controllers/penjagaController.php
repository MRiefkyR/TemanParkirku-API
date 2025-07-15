<?php

namespace App\Http\Controllers;

use App\Models\Penjaga;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class penjagaController extends Controller
{
    public function updatePenjaga(Request $request)
    {
        try {
            // Set proper headers for JSON response
            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ];

            // Log request untuk debugging
            Log::info('Update Penjaga Request:', [
                'user_id' => auth()->id(),
                'has_file' => $request->hasFile('foto'),
                'content_type' => $request->header('Content-Type'),
                'files' => $request->allFiles(),
                'data' => $request->except(['foto'])
            ]);

            $pengguna = Penjaga::where('user_id', auth()->id())->first();

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
                $fotoPath = $file->storeAs('penjaga/photos', $filename, 'public');
                
                Log::info('File uploaded successfully:', ['path' => $fotoPath]);
            }

            // Update tabel 'penjaga'
            $pengguna->update([
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'foto' => $fotoPath,
                'updated_at' => now()
            ]);

            // Update juga nama di tabel 'users'
            $user = $pengguna->user;
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
                'message' => 'Data pengguna berhasil diupdate',
                'data' => $responseData
            ], 200, $headers);

        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Database error updating penjaga:', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan database'
            ], 500, ['Content-Type' => 'application/json']);

        } catch (\Exception $e) {
            Log::error('Error updating penjaga:', [
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

    public function profilePenjaga()
    {
        try {
            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ];

            $pengguna = Penjaga::with('user')->where('user_id', auth()->id())->first();

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

    //WEB ADMIN
    public function index()
    {
        try {
            $data = Penjaga::with('user')->get();
            
            // Tambahkan URL foto untuk setiap penjaga
            $data->each(function ($penjaga) {
                if ($penjaga->foto) {
                    $penjaga->foto_url = $this->getPhotoUrl($penjaga->foto);
                }
            });
            
            return view('penjaga.index', compact('data'));
        } catch (\Exception $e) {
            Log::error('Error in penjaga index:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengambil data');
        }
    }

    public function create()
    {
        return view('penjaga.create');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:laki-laki,perempuan',
                'alamat' => 'required|string|max:500',
                'no_hp' => 'required|string|max:20',
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
                $fotoPath = $file->storeAs('penjaga/photos', $filename, 'public');
            }

            // Buat user
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'penjaga',
            ]);

            // Buat penjaga
            Penjaga::create([
                'user_id' => $user->id,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'foto' => $fotoPath,
            ]);

            return redirect()->route('penjaga.index')->with('success', 'Penjaga berhasil ditambahkan');

        } catch (\Exception $e) {
            Log::error('Error creating penjaga:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan penjaga');
        }
    }

    public function edit($id)
    {
        try {
            $penjaga = Penjaga::with('user')->findOrFail($id);
            
            // Tambahkan URL foto jika ada
            if ($penjaga->foto) {
                $penjaga->foto_url = $this->getPhotoUrl($penjaga->foto);
            }
            
            return view('penjaga.edit', compact('penjaga'));
        } catch (\Exception $e) {
            Log::error('Error in penjaga edit:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Data penjaga tidak ditemukan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $penjaga = Penjaga::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:laki-laki,perempuan',
                'alamat' => 'required|string|max:500',
                'no_hp' => 'required|string|max:20',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Handle upload foto
            $fotoPath = $penjaga->foto;
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($penjaga->foto && Storage::exists('public/' . $penjaga->foto)) {
                    Storage::delete('public/' . $penjaga->foto);
                }
                
                // Upload foto baru
                $file = $request->file('foto');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $fotoPath = $file->storeAs('penjaga/photos', $filename, 'public');
            }

            $penjaga->update([
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'foto' => $fotoPath,
            ]);

            // Update juga nama user jika ada
            if ($penjaga->user) {
                $penjaga->user->update(['nama' => $request->nama]);
            }

            return redirect()->route('penjaga.index')->with('success', 'Data penjaga berhasil diperbarui');

        } catch (\Exception $e) {
            Log::error('Error updating penjaga:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data');
        }
    }

    public function destroy($id)
    {
        try {
            $penjaga = Penjaga::findOrFail($id);
            $user = $penjaga->user;
            
            // Hapus foto jika ada
            if ($penjaga->foto && Storage::exists('public/' . $penjaga->foto)) {
                Storage::delete('public/' . $penjaga->foto);
            }
            
            $penjaga->delete();
            if ($user) $user->delete();

            return redirect()->route('penjaga.index')->with('success', 'Penjaga berhasil dihapus');

        } catch (\Exception $e) {
            Log::error('Error deleting penjaga:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus penjaga');
        }
    }
}