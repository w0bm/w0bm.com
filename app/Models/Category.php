<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Category
 *
 * @property integer $id
 * @property string $name
 * @property string $shortname
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Video[] $videos
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereShortname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereDeletedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $users
 */
class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';

    public function videos() {
        return $this->hasMany(Video::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function baseurl() {
        return $this->shortname;
    }

    public function displayName() {
        return e($this->name);
    }
}
