<?php

namespace Anacreation\Lms\Models\LessonCompletion;

use Anacreation\Lms\Contracts\CompletionCriteriaInterface;
use Anacreation\Lms\Models\Lesson;
use Anacreation\Lms\traits\CompletionCriteriaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class TimeCompletionCriteria extends Model
    implements CompletionCriteriaInterface
{
    use CompletionCriteriaTrait;

    protected $table = "time_completions";

    protected $fillable = [
        'seconds'
    ];

    // Relation

    public function lessons(): Relation {
        return $this->morphMany(Lesson::class, 'completion_criteria');
    }

    public function createModel(array $params): CompletionCriteriaInterface {
        return $this->create($params);
    }

    public function fetchModel(array $params): CompletionCriteriaInterface {
        return $this->find($params);
    }
}
