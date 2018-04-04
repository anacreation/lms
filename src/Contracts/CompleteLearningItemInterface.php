<?php
/**
 * Author: Xavier Au
 * Date: 6/3/2018
 * Time: 5:42 PM
 */

namespace Anacreation\Lms\Contracts;


use Illuminate\Database\Eloquent\Relations\Relation;

interface CompleteLearningItemInterface
{
    public function hasCompleted(): bool;

    public function completionCriteria(): Relation;
}