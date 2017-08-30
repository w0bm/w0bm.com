<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    public $timestamps = false;

    /// RELATIONS
    public function roles() {
        return $this->hasMany(Role::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }

    /// METHODS
    public function toJson($options = 0) {
        return parent::toJson($options);
    }

    public function __toString() {
        switch ($this->icon_type) {
            case 'fa':
                return '<i class="fa fa-' . $this->icon . '"></i>';
            case 'img':
            case 'image':
                return '<img class="icon" src="/' . ltrim($this->icon, '/') . '" alt="' . $this->icon . '">';
            default:
                return '';
        }
    }
}
