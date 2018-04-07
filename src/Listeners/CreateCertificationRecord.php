<?php

namespace Anacreation\Lms\Listeners;

use Anacreation\Lms\Events\LessonCompletionEvent;
use App\Events\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CreateCertificationRecord
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(LessonCompletionEvent $event) {
        if ($event->lesson->hasCertification()) {
            DB::table('certification_user')->insert([
                'user_id'          => $event->user->id,
                'certification_id' => $event->lesson->certification->id,
                'created_at'       => Carbon::now(),
            ]);
        }

    }
}
