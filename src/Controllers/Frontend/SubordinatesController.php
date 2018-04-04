<?php

namespace Anacreation\Lms\Controllers\Frontend;

use Anacreation\Lms\Models\Curriculum;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubordinatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Anacreation\Lms\Models\Lesson $lessonRepo
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $subordinates = $request->user()->subordinates;

        return view('lms::frontend.subordinates.index',
            compact('subordinates'));
    }

    public function assignCurriculumToUser(User $user, Curriculum $curriculum) {
        $user->assignCurriculum($curriculum);

        return redirect()->back()->withStatus("Curriculum Assigned!");
    }

    public function getDetailForCurriculum(
        User $user, Curriculum $curriculum
    ): View {
        $curriculum->load('items.learning');

        return view("lms::frontend.subordinates.curricula.details",
            compact("user", "curriculum"));

    }

}
