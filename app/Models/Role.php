<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Tambahkan relasi ke User
    public function users()
    {
        return $this->hasMany(User::class);
    }



public function permissions()
{
    return $this->belongsToMany(Permission::class, 'role_has_permissions', 'role_id', 'permission_id');
}

}
