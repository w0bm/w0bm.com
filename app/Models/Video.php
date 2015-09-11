<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function getNext() {
        return Video::where('id', '>', $this->id)->orderBy('id', 'ASC')->first();
    }

    public function getPrev() {
        return Video::where('id', '<', $this->id)->orderBy('id', 'DESC')->first();
    }
}
