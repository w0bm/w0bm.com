<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ModeratorLog
 *
 * TODO: Add Reason column to database
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property string $target_type
 * @property integer $target_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ModeratorLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ModeratorLog whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ModeratorLog whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ModeratorLog whereTargetType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ModeratorLog whereTargetId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ModeratorLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ModeratorLog whereUpdatedAt($value)
 */
class ModeratorLog extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    // TODO: Refactor to use morph db type from laravel
    public function getTarget() {
        switch ($this->target_type) {
            case 'user':    return User::withTrashed()->find($this->target_id);
            case 'comment': return Comment::withTrashed()->find($this->target_id);
            case 'video':   return Video::withTrashed()->find($this->target_id);
            default: return null;
        }
    }
}