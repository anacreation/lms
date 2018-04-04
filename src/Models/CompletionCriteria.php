<?php

namespace Anacreation\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class CompletionCriteria extends Model
{
    protected $table = "learning_item_completion";

    public function learningItems(): Relation {
        return $this->morphTo();
    }

    public function completionCriteria(): Relation {
        return $this->morphTo();
    }
}
