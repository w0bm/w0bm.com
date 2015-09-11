<?php

namespace App\Models;

use Toddish\Verify\Models\User as VerifyUser;

class User extends VerifyUser
{
    public function videos() {
        return $this->hasMany(Video::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
}