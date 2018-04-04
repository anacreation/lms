<?php
/**
 * Author: Xavier Au
 * Date: 2/3/2018
 * Time: 8:40 AM
 */

namespace Anacreation\Lms\Contracts;


use Anacreation\Lms\Models\Curriculum;
use App\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;

/**
 * Interface LearningInterface
 * @package Anacreation\Lms\Contracts
 */
interface LearningItemInterface
{
    /** Assign the learning item to curriculum
     * @param \Anacreation\Lms\Models\Curriculum $curriculum
     */
    public function assignToCurriculum(Curriculum $curriculum): void;

    /**
     * Relation Between Curriculum
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function learningItem(): Relation;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getLearningItemsForCurriculumRegistration(): Collection;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param $id
     * @return \Anacreation\Lms\Contracts\LearningItemInterface|null
     */
    public function findById($id): ?LearningItemInterface;

    /**
     * Get id for learning item
     * @return mixed
     */
    public function getId();

    public function isCompletedByUser(User $user): bool;

    public function tags(): Relation;

    public function inCurriculum(Curriculum $curriculum): bool;

}