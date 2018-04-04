<?php

namespace Anacreation\Lms\Models;

use Anacreation\Lms\Contracts\IsPrerequisiteRequirementInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Prerequisite extends Model
{
    //Relation
    public function requirements(): Relation {
        return $this->hasMany(PrerequisiteRequirement::class);
    }

    public function display() {
        return $this->requirements->map->requirement_display;
    }

    public function lessonIds() {
        return $this->requirements->map(function (
            PrerequisiteRequirement $prerequisiteRequirement
        ) {
            if ($prerequisiteRequirement->requirement_type === Lesson::class) {
                return $prerequisiteRequirement->requirement_id;
            }
        })->filter(null)->values();
    }

    public function removePrerequisiteRequirement(
        IsPrerequisiteRequirementInterface $prerequisiteRequirement
    ): void {
        $this->requirements()
             ->whereRequirementType(get_class($prerequisiteRequirement))
             ->whereRequirementId($prerequisiteRequirement->id)->delete();

        if ($this->requirements()->count() === 0) {
            $this->delete();
        }
    }

}
