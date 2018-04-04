<?php
/**
 * Author: Xavier Au
 * Date: 6/3/2018
 * Time: 5:59 PM
 */

namespace Anacreation\Lms\traits;


use Anacreation\Lms\Models\CompletionCriteria;
use Anacreation\Lms\Models\Lesson;
use Illuminate\Database\Eloquent\Relations\Relation;

trait CompletionCriteriaTrait
{
    public function lesson(): Relation {
        return $this->morphMany(Lesson::class, 'completion_criteria');
    }

    public function updateModel(array $param): void {
        $this->update($param);
    }

}