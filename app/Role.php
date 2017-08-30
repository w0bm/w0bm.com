<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'description',
        'level'
    ];
    
    /// RELATIONS
    public function users() {
        return $this
            ->belongsToMany(User::class, 'role_user')
            ->withTimestamps();
    }

    public function permissions() {
        return $this
            ->belongsToMany(Permission::class, 'permission_role')
            ->withTimestamps();
    }

    /// METHODS
    public function has($permissions) {
        if (!is_array($permissions)) {
            $permissions = func_get_args();
        }
        $permissions = array_unique($permissions);

        return count($permissions) === $this
            ->permissions
            ->pluck('name')
            ->intersect($permissions)
            ->count();
    }
}
