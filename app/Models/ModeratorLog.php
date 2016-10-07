<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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