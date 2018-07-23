<?php

namespace App\Listeners;

use App\Events\AccountCreatedEvent;
use App\Events\AccountUpdatedEvent;
use App\Jobs\CreateStripeCustomerJob;
use App\Jobs\UpdateStripeCustomerJob;

class AccountListener
{

    /**
     * @param  AccountCreatedEvent  $event
     * @return void
     */
    public function created($event)
    {
        dispatch(new CreateStripeCustomerJob($event->account_id));
    }

    /**
     * @param  AccountUpdatedEvent  $event
     * @return void
     */
    public function updated($event)
    {
        dispatch(new UpdateStripeCustomerJob($event->account_id));
    }
}
