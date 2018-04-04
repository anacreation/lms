<?php
/**
 * Author: Xavier Au
 * Date: 3/3/2018
 * Time: 9:13 AM
 */

namespace Anacreation\Lms\traits;


use Anacreation\Lms\Contracts\LessonContentInterface;
use Anacreation\Lms\Models\LessonContent as Content;
use Illuminate\Database\Eloquent\Relations\Relation;

trait LessonContent
{
    public function lessonContent(): Relation {
        return $this->morphMany(Content::class, 'content');
    }

    public function createContentModel(array $params): LessonContentInterface {
        return $this->create($params);
    }

    public function updateContentModel(array $params): LessonContentInterface {
        $this->update($params);
        return $this;
    }
}