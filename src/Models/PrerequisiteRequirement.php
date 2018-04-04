<?php

namespace Anacreation\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class PrerequisiteRequirement extends Model
{
    protected $table = "prerequisite_requirement";

    protected $fillable = [
        'prerequisite_type',
        'prerequisite_id'
    ];

    // Relation
    public function prerequisites(): Relation {
        return $this->belongsTo(Prerequisite::class);
    }

    public function requirement(): Relation {
        return $this->morphTo();
    }

    public function getRequirementDisplayAttribute(): string {
        return $this->requirement->display();
    }
}
