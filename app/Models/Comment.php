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

    protected $appends = ['rendered_view'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function video() {
        return $this->belongsTo(Video::class);
    }

    public static function simplemd($text) {
        $commentcfg = config('comments');
        $nameMatcher = '/@(\w+)/i';
        $internUrlMatcher = '/https?:\/\/(?:www\.)?w0bm\.com(\S+)/i';
        $externUrlMatcher = '/(https?:\/\/(?!(?:www\.)?w0bm\.com)\S+\.\S+)/i';
        $boldMather = '/\*(.+)\*/';
        $italicMathcer = '/_(.+)_/';
        $delMatcher = '/-(.+)-/';
        $newlineMatcher = '/(^.*$)/m';
        $greentextMatcher = '/(^&gt;.*$)/m';

        $imageMatcher = '/(\<a href=\"(https:\/\/('.join('|',$commentcfg["allowedHosters"]).').*(png|gif|jpg|webp))\" target=\"_blank\" rel=\"extern\"\>.*\<\/a\>)/i';
        
        $text = preg_replace($boldMather, '<strong>$1</strong>', $text);
        $text = preg_replace($italicMathcer, '<em>$1</em>', $text);
        $text = preg_replace($externUrlMatcher, '<a href="$1" target="_blank" rel="extern">$1</a>', $text);
        $text = preg_replace($internUrlMatcher, '<a href="$1">$1</a>', $text);
        $text = preg_replace($imageMatcher, '<img src="$2" alt="Image" class="comment_image" />', $text);
        $text = preg_replace($greentextMatcher, '<span style="color:#80FF00">$1</span>', $text);
        $text = preg_replace($newlineMatcher, '$1<br>', $text);
        if(preg_match_all($nameMatcher, $text, $users) > 0) {
            foreach ($users[1] as $user) {
                if(User::whereUsername($user)->count() > 0) {
                    $text = preg_replace('/@' . $user . '/i', '<a href="/user/' . strtolower($user) . '">@' . $user . '</a>', $text);
                }
            }
        }

        return $text;
    }

    public function getRenderedViewAttribute() {
        return static::simplemd(e($this->content));
    }

    public static function isPicture($url) {
        $pictypes = [
            'jpg',
            'png',
            'gif',
            'webp',
            'bmp'
        ];

        $regex = "/^.+\.(.+)$/i";
        
        $type = [];

        if(preg_match($regex, $url, $type) > 0) {
            return in_array($type[1], $pictypes);
        }
        return false;
    }

    public function getMentioned() {
        $text = $this->content;
        $nameMatcher = '/@(\w+)/i';
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
        $regex = '/^(\^+)/m';
        $answers = [];
        if(preg_match_all($regex, $text, $answered) > 0) {
            foreach($answered[0] as $a) {
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
