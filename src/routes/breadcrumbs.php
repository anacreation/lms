<?php

// Home
use Anacreation\Etvtest\Models\Test;
use Anacreation\Lms\Models\Lesson;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Support\Collection;


Breadcrumbs::register('lesson', function ($breadcrumbs) {
    $breadcrumbs->push('Courses', route('lessons.index'));
});
Breadcrumbs::register('units', function ($breadcrumbs, Lesson $lesson) {

    $breadcrumbs->parent('lesson');

    $parent = $lesson->parents->first();
    $collection = new Collection();
    while ($parent) {
        $collection->push($parent);
        $parent = $parent->parents->first();
    };
    $collection->reverse()->each(function (Lesson $l) use ($breadcrumbs) {
        $breadcrumbs->push($l->getName(),
            route('lessons.units.index', $l));
    });

    $breadcrumbs->push($lesson->getName(),
        route('lessons.units.index', $lesson));
});
Breadcrumbs::register('question', function ($breadcrumbs, Test $test) {

    $breadcrumbs->push('Tests', route("tests.index"));
    $breadcrumbs->push($test->title, route("tests.questions.index", $test));
});
Breadcrumbs::register('start', function ($breadcrumbs, Lesson $lesson) {

    $parent = $lesson->parents->first();
    $collection = new Collection();
    while ($parent) {
        $collection->push($parent);
        $parent = $parent->parents->first();
    };
    $collection->reverse()->each(function (Lesson $l) use ($breadcrumbs) {
        $breadcrumbs->push($l->getName(),
            route('lessons.start', $l));
    });

    $breadcrumbs->push($lesson->getName(),
        route('lessons.start', $lesson));
});
