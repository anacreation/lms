<?php

/**
 * Author: Xavier Au
 * Date: 1/3/2018
 * Time: 2:10 PM.
 */

Route::group([
    'namespace' => 'Anacreation\\Lms\\Controllers',
], function () {
    Route::group([
        'middleware' => ['web'],
    ], function () {
        Route::get('/', function () {
            return view('lms::welcome');
        });

        @include 'routes/auth.php';

        Route::group([
            'middleware' => ['auth'],
        ],
            function () {
                Route::get('/password/update',
                    'UsersController@getUpdatePassword')
                     ->name('password.update');
                Route::post('/password/update',
                    'UsersController@updatePassword');

                Route::group([
                    'prefix' => 'admin',
                ],
                    function () {
                        Route::get('lessons/{lesson}/users/{user}/attempts/{attempt}/show',
                            'LessonsController@showAttemptForUser')
                             ->name('lessons.users.attempts.detail');
                        Route::get('lessons/{lesson}/users/{user}/reenabled',
                            'LessonsController@reEnabledLesson')
                             ->name('lessons.users.reenabled');
                        Route::get('lessons/{lesson}/users/{user}/attempts',
                            'LessonsController@getAttemptsForUser')
                             ->name('lessons.users.attempts');
                        Route::resource('tests', 'TestsController');
                        Route::post('tests\{test}\questions\all',
                            'TestQuestionsController@sync');
                        Route::get('tests\{test}\questions\all',
                            'TestQuestionsController@browse')
                             ->name('tests.questions.browse');
                        Route::resource('tests.questions',
                            'TestQuestionsController');

                        Route::post('lessons/{lesson}/units/order',
                            'LessonUnitsController@updateOrder')
                             ->name('lessons.units.order');
                        Route::resource('lessons.units',
                            'LessonUnitsController');
                        Route::resource('lessons', 'LessonsController');
                        Route::resource('users', 'UsersController');
                        Route::resource('curricula',
                            'CurriculaController');
                        Route::resource('curricula.learnings',
                            'CurriculumLearningsController');
                    });

                Route::group([
                    'middleware' => ['auth', 'password.reset'],
                ],
                    function () {
                        Route::get('/home', 'Frontend\\LessonsController@index')
                             ->name('home');
                        Route::post('/test/{test}/grade',
                            'Frontend\\TestsController@grade')
                             ->name('tests.grade');
                        Route::get('/lessons/{lesson}/completionTest',
                            'Frontend\\LessonsController@getCompletionTest')
                             ->name('lessons.completion.test');
                        Route::get('/lessons/catalogue',
                            'Frontend\\LessonsController@showCatalogue')
                             ->name('catalogue');
                        Route::get('/lessons/{lesson}',
                            'Frontend\\LessonsController@showLesson')
                             ->name('lessons.show');
                        Route::get('/lessons/{lesson}/start',
                            'Frontend\\LessonsController@startLesson')
                             ->name('lessons.start');
                        Route::get('/lessons/{lesson}/complete',
                            'Frontend\\LessonsController@completeLesson')
                             ->name('lessons.complete');
                        Route::get('/lessons/{lesson}/enrolled_users',
                            'Frontend\\LessonsController@getEnrolledUsers')
                             ->name('lessons.enrolled.users');
                        Route::get('/subordinates',
                            'Frontend\\SubordinatesController@index')
                             ->name('subordinates');
                        Route::get('/subordinates/{user}/curricula/{curriculum}',
                            'Frontend\\SubordinatesController@getDetailForCurriculum')
                             ->name("supervisor.show.curriculum.details");
                        Route::post('/subordinates/{user}/curricula/{curriculum}',
                            'Frontend\\SubordinatesController@assignCurriculumToUser')
                             ->name("supervisor.assign.curriculum");
                        Route::get('/users/{user}/curricula',
                            'UserCurriculaController@index')
                             ->name('users.curricula');
                        Route::post('/users/{user}/curricula',
                            'UserCurriculaController@store');
                        Route::get('/my_info',
                            'Frontend\\UsersController@getMyInfo')
                             ->name('my.info');
                        Route::put('/my_info',
                            'Frontend\\UsersController@updateMyInfo');
                        Route::get('/my_courses',
                            'Frontend\\LessonsController@getMyCourses')
                             ->name('my.courses');
                    });
            });
    });
});

require "routes/breadcrumbs.php";