<?php

namespace Anacreation\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function lessons(): Relation {
        return $this->morphedByMany(Lesson::class, 'taggable');
    }
}
