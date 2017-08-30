<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// TODO refactor to use Notifiable
class Message extends Model
{
    use SoftDeletes;

    /// RELATIONS
    public function fromUser() {
        return $this->belongsTo(User::class, 'from');
    }

    public function toUser() {
        return $this->belongsTo(User::class, 'to');
    }

    /// METHODS
    public static function send($from, $to, $subject, $content) {
        // unimplemented;
        return false;
    }

    public function scopeUnread($query) {
        return $query->whereNull('read');
    }
}
