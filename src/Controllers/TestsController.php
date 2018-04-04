<?php

namespace Anacreation\Lms\Controllers;

use Anacreation\Lms\Models\Test;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Test $testRepo): View {
        $tests = $testRepo->all();

        return view('lms::admin.tests.index', compact('tests'));
    }

    public function create(): View {
        return view('lms::admin.tests.create');
    }

    public function store(Request $request, Test $testRepo) {
        $validatedData = $this->validate($request, [
            'title'        => "required",
            'is_active'    => "required|boolean",
            'passing_rate' => "required|numeric",
        ]);

        $newTest = $testRepo->create($validatedData);

        return redirect()->route('tests.index')
                         ->withStatus("{$newTest->title} created!");
    }

    public function edit(Test $test): View {
        return view('lms::admin.tests.edit', compact("test"));
    }

    public function update(Test $test, Request $request) {
        $validatedData = $this->validate($request, [
            'title'     => "required",
            'is_active' => "required|boolean",
        ]);
        $test->update($validatedData);

        return redirect()->route('tests.index')
                         ->withStatus("{$test->title} updated!");
    }
}
