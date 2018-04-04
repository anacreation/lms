<?php

namespace Anacreation\Lms\Controllers;

use Anacreation\Etvtest\Models\Test;
use Anacreation\Lms\Enums\LessonCompletionType;
use Anacreation\Lms\Models\Lesson;
use Anacreation\Lms\Services\LessonService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LessonUnitsController extends Controller
{
    public function index(Lesson $lesson): View {
        return view('lms::admin.lessons.units.index', compact('lesson'));
    }

    public function create(Lesson $lesson, Test $testRepo): View {
        $tests = $testRepo->select('title', 'id')->get();

        return view('lms::admin.lessons.units.create',
            compact('lesson', 'tests'));
    }

    public function store(
        Lesson $lesson, Request $request, LessonService $service
    ) {
        $completionTypes = LessonCompletionType::GetCompletionTypes();
        $validatedData = $this->validate($request, [
            'title'               => 'required',
            'content'             => 'nullable',
            'content-type'        => 'required',
            'is_active'           => 'required|boolean',
            'completion_criteria' => 'required|in:' . implode(',',
                    array_values($completionTypes)),
            'test_id'             => "required_if:completion_criteria,0|in:" . implode(",",
                    Test::pluck('id')->toArray()),
            'max_attempts'        => "required_if:completion_criteria,0|numeric|min:0|nullable",
            'seconds'             => "numeric|min:1|required_if:completion_criteria,1",
        ]);
        $service->addUnitToLesson($lesson, $validatedData);

        return redirect()->route('lessons.units.index', $lesson)
                         ->withStatus("New unit: {$lesson->title} created!");
    }

    public function edit(Lesson $lesson, Lesson $unit, Test $testRepo): View {

        $unit->load([
            "completionCriteria",
            "tags",
            "contents.content",
            "prerequisites.requirements.requirement"
        ]);

        $tests = $testRepo->select('title', 'id')->get();

        return view('lms::admin.lessons.units.edit',
            compact('lesson', 'unit', 'tests'));

    }


    public function update(
        Lesson $lesson, Lesson $unit, Request $request, LessonService $service
    ) {
        $completionTypes = LessonCompletionType::GetCompletionTypes();
        $validatedData = $this->validate($request, [
            'title'               => 'required',
            'content'             => 'nullable',
            'content-type'        => 'required',
            'is_active'           => 'required|boolean',
            'completion_criteria' => 'required|in:' . implode(',',
                    array_values($completionTypes)),
            'test_id'             => "required_if:completion_criteria,0|in:" . implode(",",
                    Test::pluck('id')->toArray()),
            'max_attempts'        => "required_if:completion_criteria,0|numeric|min:0|nullable",
            'seconds'             => "numeric|min:1|required_if:completion_criteria,1",
        ]);


        return redirect()->route('lessons.units.index', $lesson)
                         ->withStatus($service->update($unit, $validatedData));
    }

    public function updateOrder(Lesson $lesson, Request $request
    ): JsonResponse {
        $data = $request->all();

        $this->updateUnitsOrder($lesson, $data);

        return response()->json(['status' => 'completed']);
    }

    private function updateUnitsOrder(Lesson $lesson, array $units) {
        $updateUnitsOrder = function (array $data) use ($lesson) {
            $lesson->children()->updateExistingPivot($data['id'],
                ['order' => $data['order']]);
        };
        array_walk($units, $updateUnitsOrder);

    }
}
