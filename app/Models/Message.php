<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model {
    use SoftDeletes;

    public function from() {
        return $this->belongsTo(User::class, 'from');
    }

    public function to() {
        return $this->belongsTo(User::class, 'to');
    }

    public static function send($from, $to, $subject, $content) {
        if(is_object($from)) $from = $from->id;
        if(is_object($to)) $to = $to->id;

        if(empty($subject)) return 'Subject must not be empty';
        if(empty($content)) return 'Content must not be empty';

        try {
            User::findOrFail($from);
            User::findOrFail($to);
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }

        $message = new static();
        $message->from    = $from;
        $message->to      = $to;
        $message->subject = $subject;
        $message->content = $content;
        $message->save();

        return $message;
    }
}