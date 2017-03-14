<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    public static $needed = 150;

    public static function getPercentage() {
        return (static::getFunds() / static::$needed) * 100;
    }

    public static function getFunds() {
        return static::sum('amount') ?? 0;
    }
}