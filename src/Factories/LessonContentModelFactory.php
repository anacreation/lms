<?php
/**
 * Author: Xavier Au
 * Date: 3/3/2018
 * Time: 10:20 AM
 */

namespace Anacreation\Lms\Factories;


use Anacreation\Lms\Contracts\LessonContentInterface;
use Anacreation\Lms\Models\LessonUnits\TextContent;

class LessonContentModelFactory
{
    public static function make(string $type): LessonContentInterface {
        switch (strtolower($type)) {
            case "text":
                return app()->make(TextContent::class);
            default:
                return null;
        }
    }
}