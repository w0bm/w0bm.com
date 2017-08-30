<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model implements Playable
{
    use SoftDeletes;

    protected $table = 'categories';

    /// RELATIONS
    // also Playable
    public function videos() {
        return $this->hasMany(Video::class);
    }

    public function baseurl() {
        return '/' . $this->shortname;
    }

    public function displayName() {
        return e($this->name);
    }
}
