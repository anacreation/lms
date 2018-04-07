<?php

namespace Anacreation\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Certification extends Model
{
    use HasMediaTrait;

    //Relation
    public function lesson(): Relation {
        return $this->belongsTo(Lesson::class);
    }

    public function users(): Relation {
        return $this->belongsToMany(LmsUser::class)
                    ->withPivot('created_at');
    }

    // Api
    public function isExpired(LmsUser $user): bool {

    }

    public function hasExpiryDate(): bool {

    }

}
