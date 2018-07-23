<?php

namespace App\Providers;


use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\AccountCreatedEvent' => [
            'App\Listeners\AccountListener@created',
        ],
        'App\Events\AccountUpdatedEvent' => [
            'App\Listeners\AccountListener@updated',
        ],


        'App\Events\TeamInviteCreatedEvent' => [
            'App\Listeners\TeamInviteListener@created',
        ],
        'App\Events\TeamInviteAcceptedEvent' => [
            'App\Listeners\TeamInviteListener@accepted',
        ],


        'App\Events\SubscriptionCreatedEvent' => [
            'App\Listeners\SubscriptionListener@created',
        ],
        'App\Events\SubscriptionCancelledEvent' => [
            'App\Listeners\SubscriptionListener@cancelled',
        ],


        'App\Events\UserConfirmedEmailEvent' => [
            'App\Listeners\UserListener@emailConfirmed',
        ],
        'App\Events\UserCreatedEvent' => [
            'App\Listeners\UserListener@created'
        ],
        'App\Events\UserEmailConfirmationResendEvent' => [
            'App\Listeners\UserListener@requestedResendConfirmationEmail',
        ],
        'App\Events\UserUpdatedEmailEvent' => [
            'App\Listeners\UserListener@emailUpdated',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
