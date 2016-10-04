<?php

namespace App\Models;

use Toddish\Verify\Models\User as VerifyUser;
use Carbon\Carbon;

/**
 * App\Models\User
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property string $remember_token
 * @property boolean $verified
 * @property boolean $disabled
 * @property array $categories
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $activation_token
 * @property-read \Illuminate\Database\Eloquent\Collection|Video[] $videos
 * @property-read \Illuminate\Database\Eloquent\Collection|Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\config('verify.models.role')[] $roles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereSalt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereVerified($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereDisabled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereActivationToken($value)
 * @method static \Illuminate\Database\Query\Builder|\Toddish\Verify\Models\User verified()
 * @method static \Illuminate\Database\Query\Builder|\Toddish\Verify\Models\User unverified()
 * @method static \Illuminate\Database\Query\Builder|\Toddish\Verify\Models\User disabled()
 * @method static \Illuminate\Database\Query\Builder|\Toddish\Verify\Models\User enabled()
 * @property boolean $background
 * @property-read \Illuminate\Database\Eloquent\Collection|ModeratorLog[] $moderator_log
 * @property-read \Illuminate\Database\Eloquent\Collection|Message[] $messagesSent
 * @property-read \Illuminate\Database\Eloquent\Collection|Message[] $messagesRecv
 * @property-read \Illuminate\Database\Eloquent\Collection|Video[] $favs
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereBackground($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCategories($value)
 */
class User extends VerifyUser
{
    protected $casts = [
        'categories' => 'array'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'banend'
    ];


    public function videos() {
        return $this->hasMany(Video::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function moderator_log() {
        return $this->hasMany(ModeratorLog::class);
    }

    public function messagesSent() {
        return $this->hasMany(Message::class, 'from');
    }

    public function messagesRecv() {
        return $this->hasMany(Message::class, 'to');
    }
    
    public function favs() {
        return $this->belongsToMany(Video::class, 'favorites');
    }

    public function hasFaved($id) {
        return ! $this->favs->filter(function($vid) use ($id) {
            return $vid->id == $id;
        })->isEmpty();
    }

    public function icon() {
        return $this->belongsTo(Icon::class, 'icon_id');
    }

    public function activeIcon() {
        $icon = $this->icon;
        if($icon === null) {
            $roles = $this->roles;
            $roles = $roles->sortByDesc('level');

            foreach($roles as $role) {
                if($role !== null) $icon = $role->icon;
            }
        }
        return $icon;
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function isBanned() {
        if($this->disabled == 1) {
            return $this->banend->eq(Carbon::create(0,0,0,0,0,0)) || $this->banend->gt(Carbon::now());
        }
        return false;
    }

}
