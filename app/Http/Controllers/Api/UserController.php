<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Ambil semua users
    public function index()
    {
        return response()->json(User::all());
    }

    // Simpan user baru
    public function store(Request $request)
    {
        // Validasi input yang diterima
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id', // Validasi role_id untuk memastikan role tersebut ada di tabel roles
        ]);

        // Membuat user baru dengan role_id
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id, // Menyimpan role_id
        ]);

        return response()->json($user, 201); // Mengembalikan response dengan status 201
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        // Validasi
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:6'
        ]);
    
        // Update data
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
    
        $passwordChanged = false;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $passwordChanged = true;
        }
    
        $user->save();
    
        return response()->json([
            'user' => $user,
            'message' => $passwordChanged ? 'User updated. Password has been changed.' : 'User updated.'
        ]);
    }

    // Hapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }

    // Update role
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role_id = $request->role_id;
        $user->save();

        return response()->json($user);
    }

        // Menambahkan method getUsers untuk mengambil semua user beserta data role
        public function getUsers()
        {
            return User::with('role')->get();
        }
}
