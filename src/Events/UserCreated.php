<?php

namespace Anacreation\Lms\Events;

use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var \App\User
     */
    public $user;
    /**
     * @var string
     */
    public $password;

    /**
     * Create a new event instance.
     *
     * @param \App\User                      $user
     * @param \Anacreation\Lms\Models\Lesson $lesson
     */
    public function __construct(User $user, string $password) {
        //
        $this->user = $user;
        $this->password = $password;
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
