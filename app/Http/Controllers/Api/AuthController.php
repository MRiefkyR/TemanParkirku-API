<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengguna; // Pastikan Anda menggunakan model yang benar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try 
        {
            $validateUser = Validator::make($request->all(),
            [
                'nama' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'alamat'   => 'required|string|max:255',
                'nomor_telepon'   => 'required|string|max:255',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
            ],401);
            }

            $user = Pengguna::create([
                'nama' => $request->nama,
                'email'=> $request->email,
                'password' => Hash::make($request->password),
                'alamat' => $request->alamat,
                'nomor_telepon' => $request->nomor_telepon,

            ]);

            return response()->json([
                'status' => true,
                'message' => 'User created succesfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ],200);

        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ],500);
        }
        
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        $pengguna = Pengguna::where('email', $request->email)->first();
    
        if (!$pengguna || !Hash::check($request->password, $pengguna->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password anda salah.'
            ], 401);
        }
    
        $token = $pengguna->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'user' => $pengguna,
            'token' => $token
        ]);
    }

    

    public function logout(Request $request)
    {
        // Cabut token yang digunakan untuk mengautentikasi pengguna
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful'], 200);
    }
}