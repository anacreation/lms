<?php

namespace Anacreation\Lms\Controllers\Frontend;

use Anacreation\Etvtest\Services\AttemptService;
use Anacreation\Etvtest\Services\GradingService;
use Anacreation\Lms\Models\Test;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestsController extends Controller
{

    public function grade(
        Test $test, Request $request, GradingService $gradingService,
        AttemptService $attemptService
    ) {
        $gradingService->grade($test, $request->get('answers'));

        $attempt = $attemptService->createAttemptForUser($test, $gradingService,
            $request->user());

        if ($test->passed($attempt)) {
            $data = [
                'passed'     => true,
                'message'    => "Passed Test",
                "attempt_id" => $attempt->id
            ];
        } else {
            $data = [
                'passed'     => false,
                'message'    => "Failed Test",
                "attempt_id" => $attempt->id
            ];
        }

        return $request->ajax() ? response()->json($data) : redirect()
            ->route('lessons.show')
            ->withStatus($data['message']);

    }
}
