<?php
/**
 * Author: Xavier Au
 * Date: 1/3/2018
 * Time: 11:37 AM
 */

namespace Anacreation\Lms\Contracts;


use Anacreation\Lms\Models\LmsUser;
use Illuminate\Database\Eloquent\Relations\Relation;

interface IsPrerequisiteRequirementInterface
{
    public function prerequisiteRequirements(): Relation;

    public function isFulfilled(LmsUser $user): bool;

    public function display(): string;
}