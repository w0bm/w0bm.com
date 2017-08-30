<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

class Video extends Model
{
    use SoftDeletes;

    /// RELATIONS
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function faved() {
        return $this->belongsToMany(
            User::class,
            'favorites',
            'video_id',
            'user_id'
        );
    }

    public static function getFirstId(Playable $related = null) {
        if ($related) {
            return $related->videos()->orderBy('id', 'asc')->first()->id;
        }
        return static::orderBy('id', 'asc')->first()->id;
    }

    public static function getLastId(Playable $related = null) {
        if ($related) {
            return $related->videos()->orderBy('id', 'desc')->first()->id;
        }
        return static::orderBy('id', 'desc')->first()->id;
    }

    public function getNext(Playable $related = null) {
        if ($related) {
            return $related
                ->videos()
                ->where('id', '>', $this->id)
                ->orderBy('id', 'asc')
                ->first();
        } else {
            return static
                ::where('id', '>', $this->id)
                ->orderBy('id', 'asc')
                ->first();
        }
    }

    public function getPrev(Playable $related = null) {
        if ($related) {
            return $related
                ->videos()
                ->where('id', '<', $this->id)
                ->orderBy('id', 'desc')
                ->first();
        } else {
            return static
                ::where('id', '<', $this->id)
                ->orderBy('id', 'desc')
                ->first();
        }
    }

    public static function getRandom(Playable $related = null) {
        if ($related) {
            $id = $related->videos()->count() - 1;
            if ($id < 0) {
                // TODO make own exception class
                throw new ModelNotFoundException;
                // return redirect()->back()->with('error', 'no videos found');
            }
            $id = mt_rand(0, $id);
            return $related->videos()->skip($id);
        }
        $id = static::count() - 1;
        if ($id < 0) {
            throw new ModelNotFoundException;
            // return redirect()->back()->with('error', 'no videos found');
        }
        $id = mt_rand(0, $id);
        return static::skip($id);
    }

    public function scopeNewlyups($query) {
        return $query->where('created_at', '>=', Carbon::now()->subHours(12));
    }

}
