<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;  

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari admin berdasarkan username
        $users = User::where('username', $request->username)->first();

        if (!$users || !Hash::check($request->password, $users->password)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Username atau password salah.'
            ], 401);
        }

        $token = $users->createToken('api-token')->plainTextToken;

        $users->load('role.permissions');

        // Jika valid, Anda bisa membuat token autentikasi (misalnya menggunakan Sanctum atau Passport)
        // Untuk contoh sederhana, kita kembalikan data admin (tanpa token)
        return response()->json([
            'status'  => 'success',
            'message' => 'Login berhasil',
            'user'   => $users,
            'token'   => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
