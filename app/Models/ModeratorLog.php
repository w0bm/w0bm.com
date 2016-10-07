<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ModeratorLog
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

    public function getTarget() {
        $target_type = $this->target_type;

        switch ($target_type) {
            case 'user': return User::find($this->target_id);
            case 'comment': return Comment::find($this->target_id);
            case 'video': return Video::find($this->target_id);
            default: return null;
        }
    }
}