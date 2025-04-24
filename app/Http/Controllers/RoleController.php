<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return Role::with('permissions')->get();
    }

    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        return response()->json(['message' => 'Role created', 'data' => $role]);
    }

    public function show($id)
    {
        return Role::with('permissions')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        return response()->json(['message' => 'Role updated', 'data' => $role]);
    }

    public function destroy($id)
    {
        Role::findOrFail($id)->delete();
        return response()->json(['message' => 'Role deleted']);
    }
}
