<?php

namespace App\Models;

use Toddish\Verify\Models\Role as VerifyRole;

class Role extends VerifyRole
{
    public function icon() {
        return $this->belongsTo(Icon::class, 'icon_id');
    }
}
