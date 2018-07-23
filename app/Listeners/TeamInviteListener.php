<?php

namespace App\Listeners;

use App\Events\TeamInviteAcceptedEvent;
use App\Events\TeamInviteCreatedEvent;
use App\Jobs\SendTeamInviteAcceptedEmailJob;
use App\Jobs\SendTeamInviteEmailJob;

class TeamInviteListener
{

    /**
     * @param TeamInviteCreatedEvent $event
     */
    public function created ($event)
    {
        dispatch(new SendTeamInviteEmailJob($event->team_invite_id));
    }

    /**
     * @param TeamInviteAcceptedEvent $event
     */
    public function accepted ($event)
    {
        dispatch(new SendTeamInviteAcceptedEmailJob($event->team_invite_id));
    }
}
