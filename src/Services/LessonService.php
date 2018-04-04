<?php
/**
 * Author: Xavier Au
 * Date: 3/3/2018
 * Time: 10:48 AM
 */

namespace Anacreation\Lms\Services;


use Anacreation\Lms\Contracts\CompletionCriteriaInterface;
use Anacreation\Lms\Factories\LessonCompletionFactory;
use Anacreation\Lms\Factories\LessonContentModelFactory;
use Anacreation\Lms\Models\Lesson;
use Anacreation\Lms\Models\Tag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class LessonService
{
    /**
     * @var Lesson
     */
    private $lesson;

    /**
     * LessonService constructor.
     */
    public function __construct(Lesson $lesson = null) {
        $this->lesson = $lesson ?? app()->make(Lesson::class);
    }

    public function create(array $validatedData): Lesson {
        $newLesson = null;
        DB::transaction(function () use ($validatedData, &$newLesson) {
            /** @var Lesson $newLesson */

            $validatedData = $this->addCompletionCriteriaData($validatedData);

            $newLesson = $this->lesson->create($validatedData);

            $this->associateTagsToLesson($newLesson, $validatedData);

            $this->updateLessonCoverPic($newLesson, $validatedData);

            $this->addContentToLesson($validatedData, $newLesson);

            $this->addPrerequisitesTo($newLesson,
                $validatedData["prerequisites"] ?? []);

        });

        return $newLesson;
    }

    public function update(
        Lesson $lesson, array $validatedData
    ): string {
        DB::beginTransaction();

        try {
            $this->updateLessonCompletionCriteriaData($lesson, $validatedData);

            $lesson->update($validatedData);

            $this->associateTagsToLesson($lesson, $validatedData);

            $this->updateLessonCoverPic($lesson, $validatedData);

            $this->updateLessonContent($lesson, $validatedData);

            $this->updateLessonPrerequisites($lesson,
                $validatedData["prerequisites"] ?? []);


            DB::commit();

            return "{$lesson->title} has been updated!";
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }

    /**
     * @param $validatedData
     * @param $this
     * @return array
     */
    private function addCompletionCriteriaData(array $validatedData): array {
        $completionCriteria = LessonCompletionFactory::make($validatedData['completion_criteria'])
                                                     ->createModel($validatedData);
        $validatedData = $this->mergeDataWithCompletionCriteria($validatedData,
            $completionCriteria);

        return $validatedData;
    }

    /**
     * @param $validatedData
     * @param $newLesson
     */
    private function addContentToLesson(array $validatedData, Lesson $newLesson
    ): void {
        $content = LessonContentModelFactory::make($validatedData['content-type'])
                                            ->createContentModel(['content' => $validatedData['content']]);

        $newLesson->addContent($content);
    }

    private function mergeDataWithCompletionCriteria(
        $validatedData, $completionCriteria
    ): array {
        $validatedData = array_merge($validatedData, [
            'completion_criteria_type' => get_class($completionCriteria),
            'completion_criteria_id'   => $completionCriteria->id,
        ]);

        return $validatedData;
    }

    private function addPrerequisitesTo(
        Lesson $lesson, array $requiredLessonIds
    ) {
        // TODO: assume all prerequisites are lessons
        foreach ($requiredLessonIds as $lessonId) {
            if ($requiredLesson = Lesson::find($lessonId)) {
                $lesson->require($requiredLesson);
            }
        }

    }

    private function removeLessonPrerequisites(Lesson $lesson, array $lessonIds
    ) {
        foreach ($lessonIds as $id) {
            if ($requiredLesson = Lesson::find($id)) {
                $lesson->removePrerequisite($requiredLesson);
            }
        }

    }


    /**
     * @param Lesson $lesson
     */
    public function setLesson(Lesson $lesson): void {
        $this->lesson = $lesson;
    }

    /**
     * @param \Anacreation\Lms\Models\Lesson $lesson
     * @param array                          $prerequisites
     */
    private function updateLessonPrerequisites(
        Lesson $lesson, array $prerequisites
    ) {

        // TODO: assume all prerequisites are lessons

        $lessonIds = $lesson->required_lesson_ids;

        foreach ($prerequisites as $newId) {
            if (!in_array($newId, $lessonIds)) {
                $this->addPrerequisitesTo($lesson, [$newId]);
            }
        }

        foreach ($lessonIds as $oldId) {
            if (!in_array($oldId, $prerequisites)) {
                $this->removeLessonPrerequisites($lesson, [$oldId]);
            }
        }
    }

    /**
     * @param \Anacreation\Lms\Models\Lesson $lesson
     * @param array                          $validatedData
     */
    private function updateLessonContent(Lesson $lesson, array $validatedData
    ): void {
        // TODO: Only single text content for each lesson
        $content = $lesson->contents()->first()->content;
        $content->updateContentModel(['content' => $validatedData['content']]);
    }

    private function updateLessonCoverPic(HasMedia $lesson, array $validatedData
    ) {
        if (isset($validatedData['coverPic'])) {
            $lesson->addMedia($validatedData['coverPic'])
                   ->toMediaCollection('coverPic');
        }
    }

    private function updateLessonCompletionCriteriaData(
        Lesson $lesson, $validatedData
    ) {
        $oldCompletionType = $lesson->completionCriteria;

        $newCompletionTypeObject = LessonCompletionFactory::make($validatedData['completion_criteria']);

        if (get_class($oldCompletionType) === get_class($newCompletionTypeObject)) {
            $this->updateCurrentCompletionType($oldCompletionType,
                $validatedData);
        } else {
            $this->removeOldCompletionModel($lesson);
            $this->assignNewCompletionModel($lesson, $newCompletionTypeObject,
                $validatedData);

        }
    }

    private function updateCurrentCompletionType(
        CompletionCriteriaInterface $oldCompletionType, $validatedData
    ) {
        $oldCompletionType->updateModel($validatedData);
    }

    private function removeOldCompletionModel(Lesson $lesson) {
        $lesson->completionCriteria()->delete();
    }

    private function assignNewCompletionModel(
        Lesson $lesson, CompletionCriteriaInterface $newCompletionTypeObject,
        array $validatedData
    ) {
        $newCriteria = $newCompletionTypeObject->createModel($validatedData);
        $lesson->update([
            'completion_criteria_type' => get_class($newCriteria),
            'completion_criteria_id'   => $newCriteria->id,
        ]);
    }

    private function associateTagsToLesson(
        Lesson $lesson, array $validatedData
    ) {
        if (isset($validatedData['tags'])) {
            $collection = new Collection();
            foreach ($validatedData['tags'] as $tag) {
                if (!empty($tag)) {
                    $collection->push(Tag::firstOrCreate(['name' => $tag], []));
                }
            }
            $lesson->syncTags($collection);
        }
    }

    public function addUnitToLesson(Lesson $lesson, array $validatedData
    ): void {
        $new_lesson = $this->create($validatedData);
        $lesson->children()->save($new_lesson);
    }

    public function updateLessonUnit(Lesson $lesson, array $validatedData
    ): void {
        $new_lesson = $this->create($validatedData);
    }
}