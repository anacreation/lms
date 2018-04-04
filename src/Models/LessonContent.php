<?php

namespace Anacreation\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class LessonContent extends Model
{
    protected $fillable = [
        'lesson_id'
    ];

    public function lesson(): Relation {
        return $this->belongsTo(Lesson::class);
    }

    public function content(): Relation {
        return $this->morphTo();
    }

}
