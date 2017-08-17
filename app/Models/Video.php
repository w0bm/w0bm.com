<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $faved
 * @property-read \Illuminate\Database\Eloquent\Collection|Tag[] $tags
 * @property-read mixed $tag_list
 * @property-read mixed $tag_list_normalized
 * @property-read mixed $tag_array
 * @property-read mixed $tag_array_normalized
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Video newlyups()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Video withAllTags($tags)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Video withAnyTags($tags = array())
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Video withoutTags()
 */
class Video extends Model
{
    use SoftDeletes;
    use \Cviebrock\EloquentTaggable\Taggable;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function faved() {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function getFirstId($category) {
        if($category) {
            return static::whereCategoryId($this->category->id)->filtered()->first()->id;
        }
        return static::filtered()->first()->id;
    }

    public function getLastId($category) {
        if($category) {
            return static::whereCategoryId($this->category->id)->filtered()->max('id');
        }
        // TODO: optimize
        return static::select('id')->filtered()->orderBy('id', 'DESC')->pluck('id');
    }

    /**
     * @param bool $category
     * @return Video
     */
    public function getNext($category = false) {
        if(!$category) {
            return Video::filtered()->where('id', '>', $this->id)->orderBy('id', 'ASC')->first();
        } else {
            return Video::whereCategoryId($this->category->id)->filtered()->where('id', '>', $this->id)->orderBy('id', 'ASC')->first();
        }
    }

    /**
     * @param bool $category
     * @return Video
     */
    public function getPrev($category = false) {
        if(!$category) {
            return Video::filtered()->where('id', '<', $this->id)->orderBy('id', 'DESC')->first();
        } else {
            return Video::whereCategoryId($this->category->id)->filtered()->where('id', '<', $this->id)->orderBy('id', 'DESC')->first();
        }
    }

    public function scopeNewlyups($query) {
        return $query->where('created_at', '>=', Carbon::now()->subHours(12));
    }

    public function scopeFiltered($query) {
        if(auth()->check()) {
            // TODO rename to filtered
            $categories = auth()->user()->categories;
            if(empty($categories))
                return $query;

            return $query->withoutAnyTags($categories);
        } else {
            // TODO: filter if post has sfw & nsfw tags
        return $query->withAllTags('sfw');
        //return $query;
        }
    }

    public function checkFileEncoding() {
        $dat = $this->file;
        $in = public_path() . "/b";
        $tmpdir = str_replace("public", "app/Http/Controllers/tmp", public_path());
        for($i = 0; $i < 2; $i++) {
            $ret = shell_exec("ffmpeg -y -ss 0 -i {$in}/{$dat} -vframes 1 {$tmpdir}/test.png 2>&1");
            if(strpos($ret, "nothing was encoded") !== false) {
                shell_exec("ffmpeg -i {$in}/{$dat} -map 0:0 -map 0:1 -c:v copy {$tmpdir}/{$dat}");
                unlink($in . "/" . $dat);
                rename($tmpdir . "/" . $dat, $in . "/" . $dat);
            }
            else return true;
        }
        return false;
    }

    /**
     * Creates a .gif thumbnail to a given video file
     *
     * @param string $dat File of the video
     */
    public function createThumbnail() {
        $dat = $this->file;
        $in = public_path() . "/b"; // webm-input
        $out = public_path() . "/thumbs"; //thumb-output
        $tmpdir = str_replace("public", "app/Http/Controllers/tmp", public_path());

        $name = explode(".", $dat);
        array_pop($name);
        $name = join(".", $name);
        if(!file_exists("{$out}/{$name}.gif")) {
            $length = round(shell_exec("ffprobe -i {$in}/{$dat} -show_format -v quiet | sed -n 's/duration=//p'"));
            for ($i = 1; $i < 10; $i++) {
                $act = ($i * 10) * ($length / 100);
                $ffmpeg = shell_exec("ffmpeg -ss {$act} -i {$in}/{$dat} -vf \"scale='if(gt(a,4/3),206,-1)':'if(gt(a,4/3),-1,116)'\" -vframes 1 {$tmpdir}/{$name}_{$i}.png 2>&1");
            }
            $tmp = shell_exec("convert -delay 27 -loop 0 {$tmpdir}/{$name}_*.png {$out}/{$name}.gif 2>&1");
            if(@filesize("{$out}/{$name}.gif") < 2000)
                @unlink("{$out}/{$name}.gif");
            array_map('unlink', glob("{$tmpdir}/{$name}*.png"));
        }
    }

    public static function getRandom() {
        $id = static::filtered()->countScoped() - 1;
        $id = mt_rand(0, $id);
        return \App\Models\Video::filtered()->skip($id);
    }
}
