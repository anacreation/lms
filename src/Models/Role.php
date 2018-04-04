<?php

namespace Anacreation\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Role extends Model
{
    //Relation
    public function permissions(): Relation {
        return $this->belongsToMany(Permission::class);
    }
}
