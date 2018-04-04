<?php
/**
 * Author: Xavier Au
 * Date: 6/3/2018
 * Time: 5:45 PM
 */

namespace Anacreation\Lms\traits;


use Anacreation\Lms\Contracts\CompletionCriteriaInterface;
use Illuminate\Database\Eloquent\Relations\Relation;

trait LearningItemCompletionTrait
{
    public function hasCompleted(): bool {
        return false;
    }

    public function completionCriteria(): Relation {
        return $this->morphTo();
    }
}