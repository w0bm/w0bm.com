<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model {
    use SoftDeletes;

    public function from() {
        return $this->belongsTo(User::class, 'from');
    }

    public function to() {
        return $this->belongsTo(User::class, 'to');
    }
}