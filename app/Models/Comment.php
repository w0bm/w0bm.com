<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\Markdown;

/**
 * App\Models\Comment
 *
 * @property integer $id
 * @property string $content
 * @property integer $user_id
 * @property integer $video_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read User $user
 * @property-read Video $video
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereVideoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereDeletedAt($value)
 */
class Comment extends Model
{
    use SoftDeletes;

    protected $appends = ['rendered_view'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function video() {
        return $this->belongsTo(Video::class);
    }

    public static function simplemd($text) {
        $m = app()->make(Markdown::class);
        $text = $m->text($text);

        return $text;
    }

    public function getRenderedViewAttribute() {
        return static::simplemd($this->content);
    }

    public function getMentioned() {
        $text = $this->content;
        $nameMatcher = '/\B@([\w-ÄÖÜäöü]+)/i';
        $ret = [];
        if(preg_match_all($nameMatcher, $text, $users) > 0) {
            foreach ($users[1] as $user) {
                if(User::whereUsername($user)->count() > 0) {
                    $ret[] = User::whereUsername($user)->first();
                }
            }
        }

        return array_unique($ret);
    }

    public function answered() {
        $text = $this->content;
        $regex = '/^[!%*]*(\^+)/m';
        $answers = [];
        if(preg_match_all($regex, $text, $answered) > 0) {
            foreach($answered[1] as $a) {
                $answers[] = mb_strlen($a);
            }
        }
        $answers = array_unique($answers);
        $comments = $this->video->comments;
        $total = $comments->count();
        $ret = [];
        foreach($answers as $c) {
            $up = $total - $c - 1;
            if($up >= 0) {
                $ret[] = $comments->get($up)->user;
            }
        }
        return $ret;
    }
}
