<?php

namespace Anacreation\Lms\Controllers\Frontend;

use Anacreation\Etvtest\Services\TestServices;
use Anacreation\Lms\Enums\AlertTypes;
use Anacreation\Lms\Enums\LessonCompletionType;
use Anacreation\Lms\Models\Lesson;
use Anacreation\Lms\Models\LessonCompletion\TestCompletionCriteria;
use Anacreation\Lms\Services\LessonService;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LessonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Anacreation\Lms\Models\Lesson $lessonRepo
     * @return \Illuminate\Http\Response
     */
    public function index(Lesson $lessonRepo) {
        $lessons = $lessonRepo->active()->topLevel()->whereIsFeatured(true)
                              ->get();

        return view('lms::home', compact('lessons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('lms::admin.lessons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request, Lesson $lesson, LessonService $service
    ) {
        $completionTypes = LessonCompletionType::GetCompletionTypes();
        $validatedData = $this->validate($request, [
            'title'               => 'required',
            'content'             => 'required',
            'content-type'        => 'required',
            'is_visible'          => 'required|boolean',
            'is_active'           => 'required|boolean',
            'completion_criteria' => 'required|in:' . implode(',',
                    array_values($completionTypes)),
        ]);

        $newLesson = $service->create($validatedData);

        $msg = "New Lesson: {$newLesson->title} created!";

        return redirect()->route('lessons.index')->withStatus($msg);

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
    public function edit(Lesson $lesson) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Lesson                   $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson) {
        //
    }


    public function showCatalogue(Lesson $lessonRepo): View {
        $lessons = $lessonRepo->inCatalogue()->get();

        return view('lms::frontend.lessons.catalogue', compact('lessons'));

    }

    public function showLesson(Lesson $lesson): View {

        $lesson->load('prerequisites.requirements.requirement');
        $lesson->load('contents.content');

        return view('lms::frontend.lessons.show', compact('lesson'));
    }

    public function startLesson(Lesson $lesson, Request $request) {

        // TODO: fix enrollment
        if (!$request->user()
                     ->isEnrolled($lesson) and $lesson->canBeEnrolled()) {
            $request->user()->enroll($lesson);
        }

        if (!$request->user()->canStart($lesson)) {
            return redirect()->back()
                             ->withStatus([
                                 'type'    => AlertTypes::Danger,
                                 'message' => "Cannot Start the lesson, please contact Instructor"
                             ]);
        }


        $request->user()->start($lesson);

        $lesson->load([
            'contents' => function (Relation $query) {
                return $query->orderBy('order');
            }
        ]);


        return view('lms::frontend.lessons.start', compact('lesson'));
    }

    /**
     * @param \Illuminate\Http\Request       $request
     * @param \Anacreation\Lms\Models\Lesson $lesson
     * @return mixed
     */
    public function completeLesson(Request $request, Lesson $lesson = null) {

        if ($lesson->isCompletedBy("click")) {
            $request->user()->complete($lesson);
            $msg = "Lesson Completed!";
        } elseif ($lesson->isCompletedBy("time") and $request->ajax()) {
            $request->user()->complete($lesson);
            $msg = "Lesson Completed!";

            return response()->json([
                'status'  => "completed",
                'message' => $msg
            ]);
        } elseif ($lesson->isCompletedBy("test")) {
            if ($request->user()
                        ->passedTest($lesson->completionCriteria->test)) {
                $request->user()->complete($lesson);
                $status = [
                    'type'    => AlertTypes::Success,
                    'message' => "Lesson Completed!"
                ];

            } else {

                $status = [
                    'type'    => AlertTypes::Warning,
                    'message' => "You have fail the test pls try again!"
                ];

                $user_attempts = $request->user()->attempts()
                                         ->whereTestId($lesson->completionCriteria->test->id)
                                         ->count();
                if ($lesson->completionCriteria->max_attempts > 0 and $lesson->completionCriteria->max_attempts <= $user_attempts) {
                    $request->user()->markFailedLesson($lesson);
                    $status = [
                        'type'    => AlertTypes::Warning,
                        'message' => "You fail too much!"
                    ];
                }

            }

            return redirect()->route('home')->withStatus($status);
        } else {
            $msg = "Lesson cannot complete!";
        }

        return redirect()->route('lessons.start',$lesson)->withStatus($msg);
    }

    public function getCompletionTest(Lesson $lesson, TestServices $services
    ): View {
        if ($lesson->completionCriteria instanceof TestCompletionCriteria) {
            $test = $services->getTestByIdForStudents($lesson->completionCriteria->test_id);

            return view("lms::frontend.lessons.completionTest",
                compact('lesson', 'test'));
        }
        abort(404);
    }

    public function getEnrolledUsers(Lesson $lesson, Request $request): View {
        $lesson->load('enrollments.user');

        return view("lms::admin.lessons.enrolled_users", compact("lesson"));
    }

    public function getMyCourses(Request $request): View {
        $user = $request->user();
        $lessonStatus = $user
            ->lessonStatus()
            ->with('lesson')
            ->latest()
            ->whereNotIn('lesson_id', function ($query) {
                return $query->from("collection_lesson")
                             ->select("lesson_id");
            })
            ->whereNotIn('lesson_id',
                $user->getAssignedCurricula()
                    ->map
                    ->items->flatten()->map->learning->pluck('id'))
            ->select('user_id', 'lesson_id', 'status')
            ->get()
            ->groupBy('lesson_id');

        return view('lms::frontend.lessons.my_courses',
            compact('lessonStatus', 'user'));
    }
}
