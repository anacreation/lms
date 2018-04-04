<?php

namespace Anacreation\Lms\Models;

use Anacreation\Lms\Contracts\LearningItemInterface;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curriculum extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name'
    ];

    // Relation
    public function items(): Relation {
        return $this->hasMany(CurriculumItem::class);
    }

    public function users(): Relation {
        return $this->belongsToMany(User::class)->withPivot('due_date');
    }


    // Helper

    /**
     * @param LearningItemInterface $learning
     */
    public function add(LearningItemInterface $learning): void {
        $learning->learningItem()->create([
            'curriculum_id' => $this->id
        ]);
    }

    /**
     * @param LearningItemInterface $learning
     */
    public function remove(LearningItemInterface $learning): void {
        $learning->learningItem()->whereCurriculumId($this->id)->delete();
    }

    public function removeAllLearning(): void {
        $this->items()->delete();
    }

    public function hasLearning(LearningItemInterface $learning): bool {
        return !!$learning->learningItem()->whereCurriculumId($this->id)
                          ->count();
    }
}
