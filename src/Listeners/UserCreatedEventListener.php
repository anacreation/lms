<?php

namespace Anacreation\Lms\Listeners;

use Anacreation\Lms\Events\UserCreated;
use App\Events\Event;
use Illuminate\Support\Facades\Mail;

class UserCreatedEventListener
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
    public function handle(UserCreated $event) {
        Mail::send("lms::emails.NewUserCreatedEmail", [
            'user'     => $event->user,
            'password' => $event->password,
        ], function ($m) use ($event) {
            $m->to($event->user->email, $event->user->name)
              ->subject("Welcome to join A & A LMS");
        });

    }
}
