<?php
/**
 * Author: Xavier Au
 * Date: 3/3/2018
 * Time: 10:27 AM
 */

namespace Anacreation\Lms\Contracts;


use Illuminate\Database\Eloquent\Relations\Relation;

interface CompletionCriteriaInterface
{
    public function createModel(array $params): CompletionCriteriaInterface;

    public function fetchModel(array $params): CompletionCriteriaInterface;

    public function updateModel(array $params): void;
}