<?php

namespace Anacreation\Lms\Models;

use Anacreation\Etvtest\Models\Attempt;
use Anacreation\Etvtest\Models\Test as EtvTest;
use Illuminate\Database\Eloquent\Relations\Relation;

class Test extends EtvTest
{
    protected $fillable = [
        'title',
        'is_active',
        'passing_rate'
    ];

    // Relation
    public function attempts(): Relation {
        return $this->hasMany(Attempt::class);
    }


    public function passed(Attempt $attempt): bool {
        return $attempt->score * 100 > $this->passing_rate;
    }
}
