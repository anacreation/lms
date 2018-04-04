<?php
/**
 * Author: Xavier Au
 * Date: 2/3/2018
 * Time: 8:44 AM
 */

namespace Anacreation\Lms\traits;


use Anacreation\Lms\Models\Curriculum;
use Anacreation\Lms\Models\CurriculumItem;
use Anacreation\Lms\Models\Enrollment;
use Anacreation\Lms\Models\Tag;
use Illuminate\Database\Eloquent\Relations\Relation;

trait LearningItem
{
    public function assignToCurriculum(Curriculum $curriculum): void {
        $curriculum->add($this);
    }

    public function learningItem(): Relation {
        return $this->morphMany(CurriculumItem::class, 'learning');
    }

    public function enrollments(): Relation {
        return $this->morphMany(Enrollment::class, 'learning');
    }

    public function tags(): Relation {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function inCurriculum(Curriculum $curriculum): bool {
        return $curriculum->hasLearning($this);
    }
}