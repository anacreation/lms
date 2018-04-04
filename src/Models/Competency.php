<?php

namespace Anacreation\Lms\Models;

use Anacreation\Lms\Contracts\IsPrerequisiteRequirementInterface;
use Anacreation\Lms\traits\Prerequisiteable;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Competency extends Model implements IsPrerequisiteRequirementInterface
{
    use Prerequisiteable;

    // Relation
    public function users(): Relation {
        return $this->belongsToMany(User::class)->withPivot('created_at');
    }

    // helpers
    public function isFulfilled(User $user): bool {
        return !!$this->users()->find($user->id);
    }

    public function display(): string {
        return $this->name;
    }
}
