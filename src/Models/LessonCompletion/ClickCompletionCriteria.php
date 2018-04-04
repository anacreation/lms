<?php

namespace Anacreation\Lms\Models\LessonCompletion;

use Anacreation\Lms\Contracts\CompletionCriteriaInterface;
use Anacreation\Lms\traits\CompletionCriteriaTrait;
use Illuminate\Database\Eloquent\Model;

class ClickCompletionCriteria extends Model
    implements CompletionCriteriaInterface
{
    use CompletionCriteriaTrait;

    protected $table = "click_completions";

    public function createModel(array $params): CompletionCriteriaInterface {
        return $this->create([]);
    }

    public function fetchModel(array $params): CompletionCriteriaInterface {
        return $this->firstOrCreate([]);
    }

    public function updateModel(array $params): void {
        $this->update([]);
    }

}
