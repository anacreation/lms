<?php
/**
 * Author: Xavier Au
 * Date: 3/3/2018
 * Time: 9:13 AM
 */

namespace Anacreation\Lms\Contracts;


use Illuminate\Database\Eloquent\Relations\Relation;

interface LessonContentInterface
{
    public function lessonContent(): Relation;

    public function createContentModel(array $params): LessonContentInterface;

    public function updateContentModel(array $params): LessonContentInterface;

    public function show();
}