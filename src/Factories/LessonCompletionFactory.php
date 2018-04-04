<?php
/**
 * Author: Xavier Au
 * Date: 3/3/2018
 * Time: 10:26 AM
 */

namespace Anacreation\Lms\Factories;


use Anacreation\Lms\Contracts\CompletionCriteriaInterface;
use Anacreation\Lms\Enums\LessonCompletionType;
use Anacreation\Lms\Models\LessonCompletion\ClickCompletionCriteria;
use Anacreation\Lms\Models\LessonCompletion\TestCompletionCriteria;
use Anacreation\Lms\Models\LessonCompletion\TimeCompletionCriteria;

class LessonCompletionFactory
{
    public static function make(int $completionType): CompletionCriteriaInterface {
        switch ($completionType) {
            case LessonCompletionType::TEST:
                return app()->make(TestCompletionCriteria::class);
            case LessonCompletionType::TIME:
                return app()->make(TimeCompletionCriteria::class);
            default:
                return app()->make(ClickCompletionCriteria::class);
        }
    }
}