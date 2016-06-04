<?php

namespace App\Models;

use Toddish\Verify\Models\User as VerifyUser;

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
 */
class User extends VerifyUser
{
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

    public function categories() {
        return $this->belongsToMany(Category::class);
    }
}