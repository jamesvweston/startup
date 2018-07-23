<?php

namespace App\Events;


use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TeamInviteCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    /**
     * @var int
     */
    public $team_invite_id;


    /**
     * @param int   $team_invite_id
     */
    public function __construct($team_invite_id)
    {
        $this->team_invite_id               = $team_invite_id;
    }

}
