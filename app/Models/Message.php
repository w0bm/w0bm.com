<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Message
 *
 * @property integer $id
 * @property integer $from
 * @property integer $to
 * @property string $content
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property string $read
 * @property string $subject
 * @property-read User $fromUser
 * @property-read User $toUser
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereTo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereRead($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereSubject($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message unread()
 */
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