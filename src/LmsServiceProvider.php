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

        $this->publishPublishAssets();
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

    private function publishPublishAssets() {

        $this->publishes([
            __DIR__ . '/public/assets/js/app.js'      => public_path('js/vendor/lms/app.js'),
            __DIR__ . '/public/assets/js/manifest.js' => public_path('js/vendor/lms/manifest.js'),
            __DIR__ . '/public/assets/js/vendor.js'   => public_path('js/vendor/lms.js'),
            __DIR__ . '/public/assets/css/app.css'    => public_path('css/vendor/lms/app.css'),
            __DIR__ . '/resources/assets/js/ckeditor' => public_path('js/vendor/ckeditor'),
        ], 'public');
    }
}
