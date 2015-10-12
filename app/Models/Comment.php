<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function video() {
        return $this->belongsTo(Video::class);
    }

    public static function simplemd($text)
    {
        $nameMatcher = '/@(\w+)/i';
        $internUrlMatcher = '/https?:\/\/(?:www\.)?w0bm\.com(\S+)/i';
        $externUrlMatcher = '/(https?:\/\/(?!(?:www\.)?w0bm\.com)\S+\.\S+)/i';
        $boldMather = '/\*(.+)\*/';
        $italicMathcer = '/_(.+)_/';
        $delMatcher = '/-(.+)-/';
        $newlineMatcher = '/(^.*$)/m';
        
        if(preg_match_all($nameMatcher, $text, $users) > 0) {
            foreach ($users as $user) {
                if(User::whereUsername($user[0])->count() > 0) {
                    $text = preg_replace('/@' . $user[0] . '/i', '<a href="/user/' . strtolower($user[0]) . '">@' . $user[0] . '</a>', $text);
                }
            }
        }
        $text = preg_replace($boldMather, '<strong>$1</strong>', $text);
        $text = preg_replace($italicMathcer, '<em>$1</em>', $text);
        $text = preg_replace($delMatcher, '<s>$1</s>', $text);
        $text = preg_replace($externUrlMatcher, '<a href="$1" target="_blank" rel="extern">$1</a>', $text);
        $text = preg_replace($internUrlMatcher, '<a href="$1">$1</a>', $text);
        $text = preg_replace($newlineMatcher, '$1<br>', $text);
        

        return $text;
    }
}
