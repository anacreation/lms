<?php

namespace Anacreation\Lms\Controllers;

use Anacreation\Lms\Models\Curriculum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CurriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Curriculum $curriculum) {
        $curricula = $curriculum->all();

        return view("lms::admin.curricula.index", compact("curricula"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('lms::admin.curricula.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Curriculum $curriculum) {
        $validatedData = $this->validate($request, [
            'name' => 'required'
        ]);
        $newCurriculum = $curriculum->create($validatedData);

        return redirect()->route('curricula.index')
                         ->withStatus("New Curriculum: {$newCurriculum->name} created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  Curriculum $curriculum
     * @return \Illuminate\Http\Response
     */
    public function show(Curriculum $curriculum) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Curriculum $curriculum
     * @return \Illuminate\Http\Response
     */
    public function edit(Curriculum $curriculum) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Curriculum               $curriculum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curriculum $curriculum) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Curriculum $curriculum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curriculum $curriculum) {
        //
    }
}
