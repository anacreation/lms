<?php
/**
 * Author: Xavier Au
 * Date: 28/3/2018
 * Time: 2:54 PM
 */

namespace Anacreation\Lms\Models;

use Anacreation\Etvtest\Models\Attempt;
use Anacreation\Lms\Contracts\IsPrerequisiteRequirementInterface;
use Anacreation\Lms\Contracts\LearningItemInterface;
use Anacreation\Lms\Enums\UserLessonStatus;
use Anacreation\Lms\Events\LessonCompletionEvent;
use Anacreation\Lms\Models\UserLessonStatus as UserLessonStatusModel;
use Anacreation\Lms\traits\RoleAndPermission;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class LmsUser extends Authenticatable
{
    use Notifiable, RoleAndPermission, SoftDeletes;


    #region Relation

    public function certifications(): Relation {
        return $this->belongsToMany(Certification::class)
                    ->withPivot('created_at');
    }

    public function competencies(): Relation {
        return $this->belongsToMany(Competency::class)->withPivot('created_at');
    }

    public function curricula(): Relation {
        return $this->belongsToMany(Curriculum::class)->withPivot('due_date');
    }

    public function lessons(): Relation {
        return $this->belongsToMany(Lesson::class)->withPivot([
            'status',
            'created_at'
        ])->using(UserLessonStatusModel::class)
                    ->as('status');
    }

    public function supervisor(): Relation {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function subordinates(): Relation {
        return $this->hasMany(User::class, 'supervisor_id');
    }

    public function attempts(): Relation {
        return $this->hasMany(Attempt::class);
    }

    public function enrollments(): Relation {
        return $this->hasMany(Enrollment::class);
    }

    public function lessonStatus(): Relation {
        return $this->hasMany(\Anacreation\Lms\Models\UserLessonStatus::class);
    }

    #endregion


    #region Scope

    public function scopeExcludeMe($query, User $user = null): Builder {
        $id = $user ? $user->id : $this->id;

        return $query->where('id', "<>", $id);
    }


    #endregion


    // public API
    public function acquire(Competency $competency, Carbon $timestamp = null
    ): void {
        $timestamp = $timestamp ?? Carbon::now();
        $this->competencies()
             ->save($competency, ['created_at' => $timestamp]);
    }

    public function hasFulfillRequirementsFor(
        IsPrerequisiteRequirementInterface $lesson
    ): bool {
        $completedRequiredLesson = function (
            IsPrerequisiteRequirementInterface $requirement
        ) {
            return $requirement->isFulfilled($this);
        };

        return $lesson->prerequisites->every(function (
            Prerequisite $prerequisite
        ) use ($completedRequiredLesson) {
            return $prerequisite->requirements->every(function (
                PrerequisiteRequirement $requirement
            ) use ($completedRequiredLesson) {

                $result = $completedRequiredLesson($requirement->requirement);

                return $result;
            });
        });
    }

    public function complete(Lesson $lesson): void {
        $this->__updateLessonStatus($lesson, UserLessonStatus::COMPLETED);

        event(new LessonCompletionEvent($this, $lesson));
    }

    public function updateLessonStatus(Lesson $lesson, int $lessonStatus
    ): void {
        switch ($lessonStatus) {
            case UserLessonStatus::COMPLETED:
                $this->complete($lesson);
                break;
            case UserLessonStatus::ENROLLED:
                $this->__updateLessonStatus($lesson,
                    UserLessonStatus::ENROLLED);
                break;
            case UserLessonStatus::FAILED:
                $this->__updateLessonStatus($lesson,
                    UserLessonStatus::FAILED);
                break;
            case UserLessonStatus::DROPPED:
                $this->__updateLessonStatus($lesson,
                    UserLessonStatus::DROPPED);
                break;
            case UserLessonStatus::CANCELLED:
                $this->__updateLessonStatus($lesson,
                    UserLessonStatus::CANCELLED);
                break;
            default:
                throw new \InvalidArgumentException("Invalid lesson status");
        }
    }

    public function hasCompletedLesson(Lesson $lesson): bool {
        return UserLessonStatusModel::where([
                ['user_id', "=", $this->id],
                ['lesson_id', "=", $lesson->id],
                ['status', "=", UserLessonStatus::COMPLETED],
            ])->latest()->count() > 0;
    }

    public function assignCurriculum(
        Curriculum $curriculum, Carbon $carbon = null
    ): void {
        $carbon ?
            $this->curricula()->save($curriculum,
                ['due_date' => $carbon]) : $this->curricula()
                                                ->save($curriculum);

    }

    public function removeCurriculum(Curriculum $curriculum): void {
        $this->curricula()->detach($curriculum->id);
    }

    public function getAssignedCurricula(): Collection {
        return $this->curricula;
    }

    public function hasCurriculum(Curriculum $curriculum): bool {
        return in_array($curriculum->id,
            $this->curricula->pluck('id')->toArray());
    }

    public function assignSubordinates($subordinates): void {
        if ($subordinates instanceof Collection) {
            foreach ($subordinates as $subordinate) {
                $this->assignSubordinates($subordinate);
            }
        } elseif ($subordinates instanceof User) {
            $this->subordinates()->save($subordinates);
        }

    }

    public function assignSupervisor(User $supervisor): void {
        $this->supervisor()->associate($supervisor);
        $this->save();
    }

    public function displayRoles(string $template): string {
        return $this->roles->reduce(function (string $previous, Role $role) use
        (
            $template
        ) {
            return $previous .= sprintf($template, $role->label);
        }, "");
    }

    public function hasSubordinates(): bool {
        return $this->subordinates()->count() > 0;
    }

    public function hasCompletedCurriculum(Curriculum $curriculum): bool {

        return $curriculum->items()->with('learning')->get()->every(function (
            CurriculumItem $item
        ) {
            return $this->hasCompletedCurriculumItem($item);
        });
    }

    public function hasCompletedCurriculumItem(CurriculumItem $item): bool {
        return $item->learning->isCompletedByUser($this);
    }

    public function passedTest(Test $test): bool {
        return $this->attempts()->latest()
                    ->first()->score * 100 > $test->passing_rate;
    }

    public function markFailedLesson(Lesson $lesson): void {
        $this->__updateLessonStatus($lesson, UserLessonStatus::FAILED);
    }

    public function enroll(LearningItemInterface $learningItem): Enrollment {
        $this->__updateLessonStatus($learningItem, UserLessonStatus::ENROLLED);

        return $this->enrollments()->create(['learning' => $learningItem]);
    }

    public function isEnrolled(LearningItemInterface $learningItem): bool {
        return !!$this->enrollments()
                      ->whereLearningType(get_class($learningItem))
                      ->whereLearningId($learningItem->id)
                      ->count() > 0;
    }

    public function start(LearningItemInterface $learningItem): void {
        $this->__updateLessonStatus($learningItem, UserLessonStatus::START);
    }

    public function reEnableForLesson(LearningItemInterface $learningItem
    ): void {
        $this->__updateLessonStatus($learningItem, UserLessonStatus::RETAKE);
    }


    public function canStart(LearningItemInterface $learningItem): bool {

        // TODO: fine tune the logic
        $status = UserLessonStatusModel::where([
            'user_id'   => $this->id,
            'lesson_id' => $learningItem->id
        ])->latest()->first();


        if (!$status) {
            return false;
        }

        switch ($status->status) {
            case UserLessonStatus::START:
            case UserLessonStatus::ENROLLED:
            case UserLessonStatus::RETAKE:
            case UserLessonStatus::COMPLETED:
                return true;
            default:
                return false;
        }
    }

    private function __updateLessonStatus($lesson, int $status) {
        UserLessonStatusModel::create([
            'user_id'   => $this->id,
            'lesson_id' => $lesson->id,
            'status'    => $status
        ]);
    }

    public function getLatestStatusForLesson(
        Lesson $lesson
    ): ?\Anacreation\Lms\Models\UserLessonStatus {
        return $this->lessonStatus()->latest()->whereLessonId($lesson->id)
                    ->first();
    }

    public function failedLesson(Lesson $lesson): bool {
        return $this->lessonStatus()->whereLessonId($lesson->id)->latest()
                    ->first()->status === UserLessonStatus::FAILED;
    }

    public function isCertified(Lesson $lesson): bool {
        // lesson has certification
        if ($lesson->hasCertification()) {
            return $this->hasCompletedLesson($lesson);
        }

        return false;
        // user has valid certification relation
        // then return true
        // otherwise return false
    }

    public function certificationIsValid(Certification $certification): bool {

        if ($certification->validity_days > 0) {
            $pivot = $this->certifications()->whereId($certification->id)
                          ->latest()
                          ->first()->pivot;

            $expiryDate = $pivot->created_at->addDays($certification->validity_days);

            return $expiryDate->gt(Carbon::now());
        }

        return true;
    }

}