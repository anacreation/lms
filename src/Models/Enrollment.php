<?php

namespace Anacreation\Lms\Models;

use Anacreation\Lms\Contracts\LearningItemInterface;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Enrollment extends Model
{

    protected $fillable = [
        'learning'
    ];

    public function user(): Relation {
        return $this->belongsTo(User::class);
    }

    public function learning(): Relation {
        return $this->morphTo();
    }

    public function setLearningAttribute(LearningItemInterface $learningItem
    ): void {
        $this->attributes['learning_type'] = get_class($learningItem);
        $this->attributes['learning_id'] = $learningItem->id;
    }
}
