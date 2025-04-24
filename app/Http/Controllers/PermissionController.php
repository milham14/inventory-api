<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    // 🔍 Ambil semua permission
    public function index()
    {
        return Permission::all();
    }

    // ➕ Tambah permission baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        $permission = Permission::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Permission created',
            'data' => $permission
        ]);
    }

    // 🔎 Lihat detail satu permission
    public function show($id)
    {
        $permission = Permission::findOrFail($id);
        return response()->json([
            'data' => $permission
        ]);
    }

    // ✏️ Update permission
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Permission updated',
            'data' => $permission
        ]);
    }

    // ❌ Hapus permission
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return response()->json([
            'message' => 'Permission deleted'
        ]);
    }
}
