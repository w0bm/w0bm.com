<?php

namespace App\Models;

class UserFavorite extends User {

    protected $table = 'users';

    // Instead of uploaded Videos get favs
    public function videos() {
        return $this->belongsToMany(Video::class, 'favorites');
    }

    public function baseurl() {
        return 'user/' . $this->username . '/favs';
    }

    public function displayName() {
        return 'Favorites (' . e($this->username) . $this->activeIcon() . ')';
    }
}
