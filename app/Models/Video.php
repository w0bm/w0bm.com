<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Video
 *
 * @property integer $id
 * @property string $file
 * @property string $interpret
 * @property string $songtitle
 * @property string $imgsource
 * @property integer $category_id
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property string $hash
 * @property-read User $user
 * @property-read Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|Comment[] $comments
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Video whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Video whereFile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Video whereInterpret($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Video whereSongtitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Video whereImgsource($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Video whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Video whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Video whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Video whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Video whereHash($value)
 */
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
