<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Banner extends Model
{
    protected $casts = [
        'sfw' => 'boolean'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'until'
    ];

    public static function getRandom($sfw = true) {
        $q = static::active();
        $sfw && $q->sfw();

        $id = $q->count() - 1;
        if ($id < 0) {
            return null;
        }
        $id = mt_rand(0, $id);

        return$q->skip($id)->first();
    }

    public function scopeSfw($query) {
        return $query->where('sfw', true);
    }

    public function scopeActive($query) {
        return $query->where('until', '>=', Carbon::now());
    }
}
