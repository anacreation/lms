<?php

namespace Anacreation\Lms\Events;

use Anacreation\Lms\Models\AbstractUser;
use Anacreation\Lms\Models\Lesson;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LessonCompletionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var \App\User
     */
    public $user;
    /**
     * @var \Anacreation\Lms\Models\Lesson
     */
    public $lesson;

    /**
     * Create a new event instance.
     *
     * @param \App\User                      $user
     * @param \Anacreation\Lms\Models\Lesson $lesson
     */
    public function __construct(AbstractUser $user, Lesson $lesson) {
        //
        $this->user = $user;
        $this->lesson = $lesson;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('channel-name');
    }
}
