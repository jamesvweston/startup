<?php

namespace App\Events;


use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UserEmailConfirmationResendEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $user_id;

    /**
     * @param int $user_id
     */
    public function __construct($user_id)
    {
        $this->user_id              = $user_id;
    }
}
