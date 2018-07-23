<?php

namespace App\Listeners;

use App\Events\UserUpdatedEmailEvent;
use App\Events\UserCreatedEvent;
use App\Jobs\SendEmailConfirmationJob;

class UserListener
{

    /**
     * @param UserCreatedEvent $event
     */
    public function created ($event)
    {
        dispatch(new SendEmailConfirmationJob($event->user_id));
    }

    /**
     * @param UserUpdatedEmailEvent $event
     */
    public function emailUpdated ($event)
    {
        dispatch(new SendEmailConfirmationJob($event->user_id));
    }

    /**
     * @param UserUpdatedEmailEvent $event
     */
    public function emailConfirmed ($event)
    {
        //  Update account in stripe
    }

    /**
     * @param UserUpdatedEmailEvent $event
     */
    public function requestedResendConfirmationEmail ($event)
    {
        dispatch(new SendEmailConfirmationJob($event->user_id));
    }

}
