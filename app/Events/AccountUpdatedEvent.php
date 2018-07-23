<?php

namespace App\Events;


use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class AccountUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $account_id;

    /**
     * @param int   $account_id
     */
    public function __construct($account_id)
    {
        $this->account_id               = $account_id;
    }

}
