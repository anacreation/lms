<?php

namespace Anacreation\Lms;

use Anacreation\Lms\Events\LessonCompletionEvent;
use Anacreation\Lms\Events\UserCreated;
use Anacreation\Lms\Listeners\CreateCertificationRecord;
use Anacreation\Lms\Listeners\UserCreatedEventListener;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class LmsServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserCreated::class           => [
            UserCreatedEventListener::class
        ],
        LessonCompletionEvent::class => [
            CreateCertificationRecord::class
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {

        Blade::doubleEncode();

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->registerEvents();
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'lms');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'lms');
        $this->publishes([
            __DIR__ . '/config/lms.php' => config_path('lms.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->mergeConfigFrom(
            __DIR__ . '/config/lms.php', 'lms'
        );
    }

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens() {
        return $this->listen;
    }

    private function registerEvents() {
        foreach ($this->listens() as $event => $listeners) {
            foreach ($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }

        foreach ($this->subscribe as $subscriber) {
            Event::subscribe($subscriber);
        }
    }
}
