<?php

namespace Anacreation\Lms\Models\LessonCompletion;

use Anacreation\Lms\Contracts\CompletionCriteriaInterface;
use Anacreation\Lms\Models\Test;
use Anacreation\Lms\traits\CompletionCriteriaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class TestCompletionCriteria extends Model
    implements CompletionCriteriaInterface
{
    use CompletionCriteriaTrait;
    protected $table = "test_completions";
    protected $fillable = ['test_id', 'max_attempts'];

    // Relation

    public function test(): Relation {
        return $this->belongsTo(Test::class);
    }

    public function createModel(array $params): CompletionCriteriaInterface {
        return $this->create($params);
    }

    public function fetchModel(array $params): CompletionCriteriaInterface {
        return $this->find($params);
    }
}
