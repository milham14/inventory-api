<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    
    public function roles()
{
    return $this->belongsToMany(Role::class, 'role_has_permissions', 'permission_id', 'role_id');
}
}
