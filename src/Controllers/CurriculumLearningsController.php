<?php

namespace Anacreation\Lms\Controllers;

use Anacreation\Lms\Models\Curriculum;
use Anacreation\Lms\Services\LearningService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CurriculumLearningsController extends Controller
{
    public function index(Curriculum $curriculum, LearningService $service) {
        $learningCollection = $service->getAllLearningForCurriculumRegistration();
        $learningIndices = $service->getCurriculumLearningIndex($curriculum);


        return view("lms::admin.curricula.learnings.index",
            compact("learningCollection", "curriculum", "learningIndices"));
    }

    public function store(
        Curriculum $curriculum, Request $request, LearningService $service
    ) {
        $service->updateCurriculumLearning($curriculum, $request->ids);

        $msg = "Learning Items has been updated!";

        return redirect()->back()->withStatus($msg);
    }
}
