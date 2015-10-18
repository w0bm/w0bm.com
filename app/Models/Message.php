<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model {
    use SoftDeletes;

    public function fromUser() {
        return $this->belongsTo(User::class, 'from');
    }

    public function toUser() {
        return $this->belongsTo(User::class, 'to');
    }

    public static function send($from, $to, $subject, $content) {
        if(empty($subject)) return 'Subject must not be empty';
        if(empty($content)) return 'Content must not be empty';

        try {
            if(!is_object($from))
                $from = User::findOrFail($from);

            if(!is_object($to))
                $to = User::findOrFail($to);
        } catch (ModelNotFoundException $e) {
            return false;
        }

        $message = new static();
        $message->from    = $from->id;
        $message->to      = $to->id;
        $message->subject = $subject;
        $message->content = $content;
        $message->save();

        return $message;
    }

    public function scopeUnread($query) {
        return $query->whereNull('read');
    }
}