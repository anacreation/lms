<?php

namespace Anacreation\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class CurriculumItem extends Model
{
    protected $table = "curriculum_learning";

    protected $fillable = [
        'curriculum_id'
    ];

    public function curriculum(): Relation {
        return $this->belongsTo(Curriculum::class);
    }

    public function learning(): Relation {
        return $this->morphTo();
    }
}
