<?php

namespace Anacreation\Lms\Models;

use Anacreation\Etvtest\Contracts\TestableInterface;
use Anacreation\Etvtest\Contracts\TestableTraits;
use Anacreation\Lms\Contracts\CompleteLearningItemInterface;
use Anacreation\Lms\Contracts\IsPrerequisiteRequirementInterface;
use Anacreation\Lms\Contracts\LearningItemInterface;
use Anacreation\Lms\Contracts\LessonContentInterface;
use Anacreation\Lms\Enums\LessonCompletionType;
use Anacreation\Lms\Enums\UserLessonStatus as Status;
use Anacreation\Lms\Models\LessonCompletion\ClickCompletionCriteria;
use Anacreation\Lms\Models\LessonCompletion\TestCompletionCriteria;
use Anacreation\Lms\Models\LessonCompletion\TimeCompletionCriteria;
use Anacreation\Lms\traits\LearningItem;
use Anacreation\Lms\traits\LearningItemCompletionTrait;
use Anacreation\Lms\traits\Prerequisiteable;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Lesson extends Model
    implements IsPrerequisiteRequirementInterface, LearningItemInterface, CompleteLearningItemInterface, HasMedia
    , TestableInterface
{
    use Prerequisiteable, LearningItem, LearningItemCompletionTrait, HasMediaTrait, TestableTraits, SoftDeletes;

    protected $fillable = [
        'title',
        'summary',
        'is_active',
        'is_visible',
        'is_featured',
        'completion_criteria_type',
        'completion_criteria_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function registerMediaCollections(): void {
        $this->addMediaCollection('coverPic')->singleFile();
    }

    # region Relation
    public function children(): Relation {
        return $this->belongsToMany(Lesson::class, 'collection_lesson',
            'collection_id', 'lesson_id')
                    ->withPivot('collection_id', 'lesson_id', 'order');
    }

    public function parents(): Relation {
        return $this->belongsToMany(Lesson::class, 'collection_lesson',
            'lesson_id', 'collection_id')
                    ->withPivot('collection_id', 'lesson_id', 'order');
    }

    public function collections(): Relation {
        return $this->belongsToMany(Lesson::class, 'collection_lesson',
            'lesson_id', 'collection_id')->withPivot('lesson_id');
    }

    public function permission(): Relation {
        return $this->belongsTo(Permission::class);
    }

    public function prerequisites(): Relation {
        return $this->hasMany(Prerequisite::class);
    }

    public function contents(): Relation {
        return $this->hasMany(LessonContent::class);
    }

    public function userStatus(): Relation {
        return $this->hasMany(UserLessonStatus::class);
    }

    public function certification(): Relation {
        return $this->hasOne(Certification::class);
    }

    #endregion

    # region scope

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTopLevel(Builder $query): Builder {
        return $query->whereNotIn('id', function ($query) {
            return $query->from("collection_lesson")->select("lesson_id");
        });
    }

    public function scopeInEnrollmentPeriod(Builder $query): Builder {
        return $query->where([
            ['enrollment_start', '<=', Carbon::now()],
            ['enrollment_end', '>', Carbon::now()],
        ])->orWhere([
            ['enrollment_start', '=', null],
            ['enrollment_end', '=', null]
        ]);
    }

    public function scopeActive(Builder $query): Builder {
        return $query->whereIsActive(true);
    }

    public function scopeVisible(Builder $query): Builder {
        return $query->whereIsVisible(true);
    }

    public function scopeInCatalogue(Builder $query): Builder {
        return $query->visible()->active()->topLevel();
    }

    #endregion

    # region accessor

    public function getIsRestrictedAttribute(): bool {
        return !!$this->permission;
    }

    public function getHasChildrenAttribute(): bool {
        return !!$this->children->count();
    }



    #endregion

    #region interface implementations

    public function getLearningItemsForCurriculumRegistration(): Collection {
        return $this->topLevel()->get();
    }

    public function getName(): string {
        return $this->title;
    }

    public function findById($id): ?LearningItemInterface {
        return $this->find($id);
    }

    public function getId() {
        return $this->id;
    }

    #endregion

    // public API
    public function require(
        IsPrerequisiteRequirementInterface $prerequisiteRequirement,
        Prerequisite $prerequisite = null
    ): Prerequisite {
        $prerequisite = $prerequisite ?? $this->prerequisites()->create();
        $prerequisiteRequirement->prerequisiteRequirements()->create([
            'prerequisite_id' => $prerequisite->id
        ]);

        return $prerequisite;
    }

    public function removePrerequisite(
        IsPrerequisiteRequirementInterface $prerequisiteRequirement
    ): void {
        $this->prerequisites->each->removePrerequisiteRequirement($prerequisiteRequirement);

    }

    public function addAlternativeRequirement(
        IsPrerequisiteRequirementInterface $prerequisiteRequirement,
        Prerequisite $prerequisite
    ): void {
        $prerequisiteRequirement->prerequisiteRequirements()->create([
            'prerequisite_id' => $prerequisite->id
        ]);
    }

    public function createAlternativeRequirements(iterable $items): void {
        $prerequisite = null;
        foreach ($items as $item) {
            if ($item instanceof IsPrerequisiteRequirementInterface) {
                $prerequisite = $prerequisite ?? $this->prerequisites()
                                                      ->create();

                $this->require($item, $prerequisite);
            }
        }
    }

    public function swapRequirement(
        IsPrerequisiteRequirementInterface $old_requirement,
        IsPrerequisiteRequirementInterface $new_requirement
    ): ?Prerequisite {
        $prerequisite = $this->prerequisites()->with([
            'requirements' => function (Relation $query) use ($old_requirement
            ) {
                return $query->where([
                    ['requirement_type', '=', get_class($old_requirement)],
                    ['requirement_id', '=', $old_requirement->id],
                ]);
            }
        ])->get()->first(function (Prerequisite $prerequisite) {
            return $prerequisite->requirements->count() > 0;
        });

        if ($prerequisite) {
            foreach ($prerequisite->requirements as $requirement) {
                if ($requirement->id === $old_requirement->id) {
                    $requirement->delete();
                }
            }
            $new_requirement->prerequisiteRequirements()->create([
                'prerequisite_id' => $prerequisite->id
            ]);
        }

        return $prerequisite;

    }

    public function isFulfilled(LmsUser $user): bool {
        return !!UserLessonStatus::where([
            ['user_id', '=', $user->id,],
            ['lesson_id', '=', $this->id,],
            ['status', '=', Status::COMPLETED],
        ])->first();
    }

    public function isCompletedByUser(User $user): bool {
        return !!UserLessonStatus::where([
            ['user_id', '=', $user->id,],
            ['lesson_id', '=', $this->id,],
            ['status', '=', Status::COMPLETED],
        ])->latest()->first();
    }

    public function addContent(LessonContentInterface $content, int $order = 0
    ): void {
        $content->lessonContent()->create([
            'lesson_id' => $this->id,
            'order'     => $order
        ]);
    }

    public function isCompletedBy(string $completionType): bool {
        $type = LessonCompletionType::translateToType($this->completionCriteria);

        return $completionType === $type;
    }

    public function display(): string {
        return $this->title;
    }

    public function getRequiredLessonIdsAttribute(): array {
        return $this->required_lessons->map->id->toArray();
    }

    public function getRequiredLessonsAttribute(array $params = null) {
        return $this->prerequisites()
                    ->get()
            ->map
            ->requirements
            ->flatten()
            ->filter(function (PrerequisiteRequirement $requirement) {
                return $requirement->requirement_type === Lesson::class;
            })
            ->values()
            ->map
            ->requirement;

    }

    public function getCompletionTypeAttribute(): int {

        $rc = new \ReflectionClass(LessonCompletionType::class);
        $completionTypes = $rc->getConstants();
        switch ($this->completion_criteria_type) {
            case ClickCompletionCriteria::class:
                return $completionTypes['CLICK'];
            case TestCompletionCriteria::class:
                return $completionTypes['TEST'];
            case TimeCompletionCriteria::class:
                return $completionTypes['TIME'];
            default:
                return 0;
        }
    }

    public function completionTimestamp(User $user
    ): ?Carbon {

        return optional($this->userStatus()
                             ->whereUserId($user->id)
                             ->latest()
                             ->whereStatus(Status::COMPLETED)
                             ->first())->created_at;

    }

    public function showRequiredLessons(): string {
        return $this->required_lessons->map->display()->reduce(function (
            $previous, $items
        ) {
            return $previous .= $items;
        }, '');
    }

    public function canBeEnrolled(): bool {
        $lesson = $this->inEnrollmentPeriod()->active()->topLevel()
                       ->whereId($this->id)->first();
        if ($lesson) {
            return $lesson->hasVacancy();
        }

        return true;
    }

    public function hasVacancy(): bool {
        return $this->vacancies ? $this->vacancies > $this->enrollments->count() : true;
    }

    public function hasChildren(): bool {
        return $this->children()->count() > 0;
    }

    public function addTag(Tag $tag): void {
        $this->tags()->save($tag);
    }

    public function addTags(Collection $tags): void {
        if ($tags->every(function ($tag) {
            return $tag instanceof Tag;
        })) {
            $this->tags()->saveMany($tags);
        }
    }

    public function removeTag(Tag $tag): void {
        $this->tags()->detach($tag->id);
    }

    public function syncTags(Collection $tags): void {
        if ($tags->every(function ($tag) {
            return $tag instanceof Tag;
        })) {
            $this->tags()->sync($tags->pluck('id')->toArray());
        }
    }

    public function allChildrenCompleted(User $user): bool {
        if ($this->hasChildren()) {
            return $this->children->every(function ($lesson) use ($user) {
                $check = $lesson->isCompletedByUser($user);

                return $check;
            });
        }

        return true;

    }

    public function getOrderedChildren(): Collection {
        return $this->children()->orderBy('pivot_order')->get();
    }

    public function hasCertification(): bool {
        return !!$this->certification;
    }
}
