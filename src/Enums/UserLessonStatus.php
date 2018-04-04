<?php
/**
 * Author: Xavier Au
 * Date: 1/3/2018
 * Time: 12:23 PM
 */

namespace Anacreation\Lms\Enums;


class UserLessonStatus
{
    const ENROLLED  = 0;
    const COMPLETED = 1; //completed and pass the lesson
    const FAILED    = 2; //completed and failed the lesson
    const DROPPED   = 3; //cancelled lesson after the lesson started
    const CANCELLED = 4; //cancelled lesson before the lesson started
    const START     = 5; //start lesson
    const RETAKE    = 6; //retake the lesson

    public static function getStatus(): array {
        $rc = new \ReflectionClass(static::class);

        return $rc->getConstants();
    }
}