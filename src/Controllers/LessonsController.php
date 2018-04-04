<?php

namespace Anacreation\Lms\Controllers;

use Anacreation\Etvtest\Models\Attempt;
use Anacreation\Etvtest\Models\Test;
use Anacreation\Lms\Models\Lesson;
use Anacreation\Lms\Models\Tag;
use Anacreation\Lms\Requests\StoreLessonRequest;
use Anacreation\Lms\Requests\UpdateLessonRequest;
use Anacreation\Lms\Services\LessonService;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\View\View;

class LessonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Lesson $lesson) {
        $lessons = $lesson->topLevel()->get();

        return view('lms::admin.lessons.index', compact('lessons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Test $testRepo, Tag $tagRepo) {
        $tests = $testRepo->select('title', 'id')->get();
        $tags = $tagRepo->pluck('name');


        return view('lms::admin.lessons.create', compact("tests", "tags"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        StoreLessonRequest $request, LessonService $service
    ) {

        $newLesson = $service->create($request->validated());

        return redirect()->route('lessons.index')->withStatus("New Lesson: {
            $newLesson->title} created!");

    }

    /**
     * Display the specified resource.
     *
     * @param  Lesson $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Lesson $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson, Test $testRepo, Tag $tagRepo) {

        $lesson->load([
            "completionCriteria",
            "tags",
            "contents.content",
            "prerequisites.requirements.requirement"
        ]);

        $tests = $testRepo->select('title', 'id')->get();
        $tags = $tagRepo->pluck('name');

        return view("lms::admin.lessons.edit",
            compact("lesson", "tests", "tags"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Lesson                   $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateLessonRequest $request, Lesson $lesson, LessonService $service
    ) {

        return redirect()->route("lessons.index")
                         ->withStatus($service->update($lesson,
                             $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Lesson $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson) {
        $lesson->delete();

        return response()->json(['status' => 'completed', 'id' => $lesson->id]);
    }

    public function getAttemptsForUser(
        Lesson $lesson, User $user
    ): View {

        $test = $lesson->completionCriteria->test;
        $attempts = $user->attempts()->latest()
                         ->whereTestId($test->id)->get();

        return view("lms::admin.lessons.attempts.index",
            compact("attempts", "lesson", "user", "test"));
    }

    public function showAttemptForUser(
        Lesson $lesson, User $user, Attempt $attempt
    ): View {
        $test = $lesson->completionCriteria->test()->with('questions.choices')
                                           ->first();


        return view('lms::admin.lessons.attempts.show_attempt',
            compact('test', 'attempt', 'user', 'lesson'));
    }

    public function reEnabledLesson(Lesson $lesson, User $user) {
        if ($user->failedLesson($lesson)) {
            $user->reEnableForLesson($lesson);
            $msg = "Re-enable lesson {$lesson->getName()} for {$user->name}";
        } else {
            $msg = "No need to re-enable lesson!";
        }

        return redirect()->back()->withStatus($msg);
    }
}
