<?php
/**
 * Author: Xavier Au
 * Date: 2/3/2018
 * Time: 10:17 AM
 */

namespace Anacreation\Lms\Services;


use Anacreation\Lms\Contracts\LearningItemInterface;
use Anacreation\Lms\Models\Curriculum;
use Anacreation\Lms\Models\CurriculumItem;
use Illuminate\Support\Collection;

class LearningService
{
    private $newLearningObjects;

    public function getAllLearningForCurriculumRegistration(): Collection {
        $collection = new Collection();
        $registeredLearning = config('lms.learningItems');
        foreach ($registeredLearning as $learning) {
            $key = $learning['name'];
            $instance = app()->make($learning['implementation']);
            if ($instance instanceof LearningItemInterface) {
                $collection->put($key,
                    $instance->getLearningItemsForCurriculumRegistration());
            } else {
                throw new \Exception("Invalid Learning Item Implemenation. Must Confirm LearningInterface!");
            }
        }

        return $collection;
    }

    public function updateCurriculumLearning(
        Curriculum $curriculum, array $learningIdWithPrefix = null
    ): void {
        if ($learningIdWithPrefix == null) {
            $curriculum->removeAllLearning();
        } else {
            $this->parseLearningInputs($learningIdWithPrefix);
            $currentLearningItems = $curriculum->items()->get()->map(function (
                CurriculumItem $item
            ) {
                return $item->learning;
            });
            foreach ($this->newLearningObjects as $learningObject) {
                if (!$curriculum->hasLearning($learningObject)) {
                    $curriculum->add($learningObject);
                }
            }
            foreach ($currentLearningItems as $currentLearningObject) {
                if ($this->notInNewLearningObjects($currentLearningObject)) {
                    $curriculum->remove($currentLearningObject);
                }
            }
        }
    }

    private function parseLearningInputs(array $learningIdWithPrefix): void {
        $registeredLearning = config('lms.learningItems');
        $keys = [];
        $implementations = [];
        foreach ($registeredLearning as $learning) {
            $keys[] = $learning['name'];
            $implementations[$learning['name']] = $learning['implementation'];
        }

        $this->newLearningObjects = array_reduce($learningIdWithPrefix,
            function ($previous, $item) use ($keys, $implementations) {
                $splits = explode('_', $item);
                if (count($splits) === 2) {
                    $key = $splits[0];
                    $itemId = $splits[1];
                    if (in_array($key, $keys)) {
                        $instance = app()->make($implementations[$key]);
                        $item = $instance->findById($itemId);
                        if ($item) {
                            $previous[] = $item;
                        }
                    }
                }

                return $previous;
            }, []);
    }

    public function getCurriculumLearningIndex(Curriculum $curriculum) {
        $learningItems = $curriculum->items->map(function (CurriculumItem $item
        ) {
            return $item->learning;
        });

        $registeredLearning = config('lms.learningItems');
        $keys = [];
        $implementations = [];
        foreach ($registeredLearning as $learning) {
            $keys[] = $learning['name'];
            $implementations[$learning['name']] = $learning['implementation'];
        }

        $flippedImplementations = array_flip($implementations);

        $learningIndices = $learningItems->reduce(function (
            $previous, LearningItemInterface $learning
        ) use (
            $flippedImplementations
        ) {
            if (in_array(get_class($learning),
                array_keys($flippedImplementations))) {
                $index = "{$flippedImplementations[get_class($learning)]}_{$learning->getId()}";
                $previous[] = $index;
            }

            return $previous;
        });

        return $learningIndices;
    }

    private function notInNewLearningObjects(
        LearningItemInterface $currentLearningObject
    ): bool {
        /** @var LearningItemInterface $newLearningObject */
        foreach ($this->newLearningObjects as $newLearningObject) {
            if (get_class($currentLearningObject) === get_class($newLearningObject) and $newLearningObject->getId() === $currentLearningObject->getId()) {
                return false;
            }
        }

        return true;
    }
}