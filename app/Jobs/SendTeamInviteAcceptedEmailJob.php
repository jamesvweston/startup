<?php

namespace App\Jobs;

use App\Models\TeamInvite;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendTeamInviteAcceptedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * @var int
     */
    private $team_invite_id;


    /**
     * @param int   $team_invite_id
     */
    public function __construct($team_invite_id)
    {
        $this->team_invite_id       = $team_invite_id;
    }


    public function handle()
    {
        $team_invite                = TeamInvite::find($this->team_invite_id);
    }
}
