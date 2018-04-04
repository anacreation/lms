<?php

namespace Anacreation\Lms\Controllers;

use Anacreation\Etvtest\Models\Question;
use Anacreation\Etvtest\Models\Test;
use Anacreation\Etvtest\Services\CreateQuestionService;
use Anacreation\Etvtest\Services\EditQuestionServices;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Test $test, Question $questionRepo) {

        $questions = $questionRepo->all();

        return view('lms::admin.tests.questions.index',
            compact('questions', 'test'));
    }

    public function create(Test $test) {
        return view('lms::admin.tests.questions.create', compact("test"));
    }

    public function store(
        Test $test, Request $request, CreateQuestionService $service
    ) {
        Validator::extend('at_least_one_correct',
            function ($attribute, $choices, $parameters, $validator) {
                return count(array_filter($choices, function ($choice) {
                    return ($choice['is_corrected']);
                }));
            });

        $validatedData = $this->validate($request, [
            "question_type_id"  => 'required',
            "content"           => 'required',
            "is_active"         => 'required|boolean',
            "is_required_all"   => 'required|boolean',
            "choices"           => "at_least_one_correct",
            "choices.*.content" => "required"
        ],
            ["choices.at_least_one_correct" => "Have to pick at least one choice"]);

        $service->create($validatedData, $test->id);

        return $request->ajax() ? response()->json(['status' => 'completed']) : redirect()
            ->route('tests.questions.index', compact("test"))
            ->withStatus("Question created!");
    }


    public function edit(Test $test, Question $question) {
        $question->load('choices');
        $question->load('answer');

        return view('lms::admin.tests.questions.edit',
            compact("test", "question"));
    }

    public function update(
        Test $test, Question $question, Request $request,
        EditQuestionServices $service
    ) {
        Validator::extend('at_least_one_correct',
            function ($attribute, $choices, $parameters, $validator) {
                return count(array_filter($choices, function ($choice) {
                    return ($choice['is_corrected']);
                }));
            });
        Validator::extend('content_is_required',
            function ($attribute, $choice, $parameters, $validator) {
                return !$choice['active'] ? true : !!$choice['content'];
            });

        $validatedData = $this->validate($request, [
            "prefix"           => 'nullable',
            "page_number"      => 'required|numeric',
            "question_type_id" => 'required',
            "content"          => 'required',
            "is_active"        => 'required|boolean',
            "is_required_all"  => 'required|boolean',
            "choices"          => "at_least_one_correct",
            "choices.*.active" => "required|boolean",
            "choices.*"        => "content_is_required"
        ],
            ["choices.at_least_one_correct" => "Have to pick at least one choice"]);

        $service->updateQuestionById($question->id, $validatedData);

        return $request->ajax() ? response()->json(['completed' => 'true']) : redirect()
            ->route("tests.questions.index")
            ->withStaus("Question updated!");

    }

    public function destroy(Test $test, Question $question, Request $request
    ) {
        $test->questions()->detach($question->id);

        return $request->ajax() ? response()->json([
            'status' => 'completed',
            "id"     => $question->id
        ]) : redirect()
            ->route("tests.questions.index", $test)
            ->withStatus("Question remove from the test.");
    }

    public function browse(Test $test, Question $questionRepo, Request $request
    ): View {
        $questions = $questionRepo->all();
        $test->load('questions');

        return view("lms::admin.tests.questions.browse",
            compact('questions', 'test'));
    }

    public function sync(Test $test, Question $questionRepo, Request $request
    ) {
        $validatedData = $this->validate($request, [
            "question_ids.*" => 'in:' . implode(",",
                    $questionRepo->pluck('id')->toArray())
        ]);
        $test->questions()->sync($validatedData['question_ids']);

        return $request->ajax() ? response()->json([
            'status' => 'completed'
        ]) : redirect()
            ->route("tests.questions.index", $test)
            ->withStatus("Question updated.");
    }
}
