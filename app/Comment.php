<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $appends = ['rendered_view'];

    /// RELATIONS
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function video() {
        return $this->belongsTo(Video::class);
    }

    /// METHODS
    public function getMentioned() {
        $text = $this->content;
        $nameMatcher = '/@(\w+)/i';
        $ret = collect([]);
        if (0 < preg_match_all($nameMatcher, $text, $users)) {
            $ret = User::whereIn('username', $users[1])->distinct()->get();
        }
        return $ret;
    }

    public function answered() {
        $text = $this->content;
        $regex = '/^[!%*]*(\^+)/m';
        $answers = collect([]);
        if (preg_match_all($regex, $text, $answered) > 0) {
            $answers = collect($answered[1])
                ->map(function ($a) {
                    return mb_strlen($a);
                })
                ->unique();
        }
        
        $total = $this->video->comments()->count();
        $answers = $answers
            ->filter(function ($a) use ($total) {
                return 0 <= $total - $a - 1;
            })
            ->all();
        // Todo: fix
        return $this
            ->video
            ->comments
            ->only($answers) // ? why does this not work
            ->map->user;
    }

}
