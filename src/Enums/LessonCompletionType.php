<?php
/**
 * Author: Xavier Au
 * Date: 2/3/2018
 * Time: 7:38 PM
 */

namespace Anacreation\Lms\Enums;


use Anacreation\Lms\Contracts\CompletionCriteriaInterface;
use Anacreation\Lms\Models\LessonCompletion\ClickCompletionCriteria;
use Anacreation\Lms\Models\LessonCompletion\TestCompletionCriteria;
use Anacreation\Lms\Models\LessonCompletion\TimeCompletionCriteria;
use ReflectionClass;

class LessonCompletionType
{
    const TEST  = 0;
    const TIME  = 1;
    const CLICK = 2;

    public static function GetCompletionTypes(): array {
        $reflectionClass = new ReflectionClass(static::class);

        return $reflectionClass->getConstants();
    }

    public static function translateToType(CompletionCriteriaInterface $object
    ): string {

        switch (get_class($object)) {
            case TimeCompletionCriteria::class:
                return "time";
            case ClickCompletionCriteria::class:
                return "click";
            case TestCompletionCriteria::class:
                return "test";
            default:
                throw new \InvalidArgumentException("No matching completion criteria type!");
        }
    }
}