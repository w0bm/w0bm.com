<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Playable
{
    use Notifiable;

    protected $table = 'users';

    protected $casts = [
        // TODO: rename db column to tag filters
        'categories' => 'array'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'banend'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /// RELATIONS
    public function roles() {
        return $this
            ->belongsToMany(Roles::class, 'role_user')
            ->withTimestamps();
    }

    public function uploads() {
        return $this->hasMany(Video::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function moderatorLog() {
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

    public function icon() {
        return $this->belongsTo(Icon::class, 'icon_id');
    }

    /// METHODS
    public function is($roles) {
        if (!is_array($roles)) {
            $roles = func_get_args();
        }
        $roles = array_unique($roles);
        // TODO make more efficient (stop after all roles are found)
        return count($roles) === $this
            ->roles
            ->pluck('name')
            ->intersect($roles)
            ->count();
    }

    public function can($permissions) {
        // Make configurable
        if ($this->is('Super Admin')) {
            return true;
        }
        if (!is_array($permissions)) {
            $permissions = func_get_args();
        }
        $permissions = array_unique($permissions);
        return count($permissions) === $this
            ->roles
            ->pluck('permissions')
            ->flatten()
            ->pluck('name')
            ->intersect($permissions)
            ->count();
    }

    public function level($level, $modifier = '>=') {
        $levels = $this->roles->pluck('level');
        $max = $this->roles->max('level');
        $min = $this->roles->min('level');

        switch (trim($modifier)) {
            case '=' : return $levels->contains($level);
            case '>=': return $max >= $level;
            case '>' : return $max >  $level;
            case '<=': return $min <= $level;
            case '<' : return $min <  $level;
            case '!=': return !$level->contains($level);
            default: return false;
        }
    }

    public function hasFaved($id) {
        return 0 < $this
            ->favs()
            ->where('id', $id)
            ->count();
    }

    public function isBanned() {
        if($this->disabled == 1) {
            return $this->banend->eq(Carbon::create(0,0,0,0,0,0)) || $this->banend->gt(Carbon::now());
        }
        return false;
    }

    public function activeIcon() {
        $icon = $this->icon;
        if (is_null($icon)) {
            $icon = $this
                ->roles
                ->sortByDesc('level')
                ->pluck('icon')
                ->filter()
                ->first() ?? $icon;
        }
        return $icon;
    }

    public function getForeignKey() {
        return 'user_id';
    }

    /// Playable Interface
    public function baseurl() {
        return 'user/' . $this->username . '/uploads';
    }

    public function displayName() {
        return rtrim(e($this->username) . ' ' . $this->activeIcon());
    }

    public function videos() {
        return $this->uploads();
    }


}
