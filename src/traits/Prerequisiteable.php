<?php
/**
 * Author: Xavier Au
 * Date: 1/3/2018
 * Time: 11:55 AM
 */

namespace Anacreation\Lms\traits;


use Anacreation\Lms\Models\PrerequisiteRequirement;
use Illuminate\Database\Eloquent\Relations\Relation;

trait Prerequisiteable
{
    public function prerequisiteRequirements(): Relation {
        return $this->morphMany(PrerequisiteRequirement::class, 'requirement');
    }
}