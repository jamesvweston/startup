<?php

namespace App\Listeners;

use App\Events\SubscriptionCancelledEvent;
use App\Events\SubscriptionCreatedEvent;
use App\Events\SubscriptionUpdatedEvent;

class SubscriptionListener
{

    /**
     * @param  SubscriptionCreatedEvent  $event
     */
    public function created($event)
    {

    }

    /**
     * @param SubscriptionCancelledEvent $event
     */
    public function cancelled ($event)
    {

    }

}
