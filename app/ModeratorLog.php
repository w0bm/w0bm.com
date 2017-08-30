<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModeratorLog extends Model
{
    /// RELATIONS
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function target() {
        return $this->morphTo();
    }
}
