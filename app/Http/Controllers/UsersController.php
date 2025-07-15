<?php

namespace App\Http\Controllers;

use App\Models\{Pengguna, Penjaga, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function register(Request $request)
    {
        try 
        {
            $validateUser = Validator::make($request->all(), [
                'nama' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'role' => 'required|string|max:255',
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User created succesfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau password salah.'
            ], 401);
        }

        if ($user->role === 'pengguna') {
            $pengguna = Pengguna::where('user_id', $user->id)->first();
            if (!$pengguna) {
                Pengguna::create([
                    'user_id' => $user->id,
                ]);
            }
        }

        if ($user->role === 'penjaga') {
            $pengguna = Penjaga::where('user_id', $user->id)->first();
            if (!$pengguna) {
                Penjaga::create([
                    'user_id' => $user->id,
                ]);
            }
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function destroyUser(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'pengguna') {
            $pengguna = Pengguna::where('user_id', $user->id)->first();
            if ($pengguna) {
                $pengguna->delete();
            }
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Akun berhasil dihapus'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful'], 200);
    }

    // === Tambahan CRUD oleh Admin ===

    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string'
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        if ($user->role === 'pengguna') {
            Pengguna::create(['user_id' => $user->id]);
        } elseif ($user->role === 'penjaga') {
            Penjaga::create(['user_id' => $user->id]);
        }

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string'
        ]);

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'pengguna') {
            Pengguna::where('user_id', $user->id)->delete();
        } elseif ($user->role === 'penjaga') {
            Penjaga::where('user_id', $user->id)->delete();
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}
