<?php

namespace App\Events;


use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class TeamInviteAcceptedEvent
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
