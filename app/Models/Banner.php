<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

// Maybe this will in a n to m relation with video someday
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

    // If this would be in relation with video the $sfw could be
    // figured out dynamically
    public static function getRandom($sfw = true) {
        $q = static::active();
        if($sfw) $q->sfw();
        $id = $q->count() - 1;
        if ($id < 0) return null;
        $id = mt_rand(0, $id);
        $q = static::active();
        if($sfw) $q->sfw();
        return $q->skip($id)->first();
    }

    public function scopeSfw($query) {
        return $query->where('sfw', true);
    }

    public function scopeActive($query) {
        return $query->where('until', '>=', Carbon::now());
    }
}
