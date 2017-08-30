<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    public $timestamps = false;

    public static $needed = 150;

    public static function getPercentage() {
        return 100 * static::getFunds() / static::$needed;
    }

    public static function getFunds() {
        return static::sum('amount') ?? 0;
    }
}
