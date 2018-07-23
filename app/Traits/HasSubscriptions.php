<?php

namespace App\Traits;


use App\Models\Subscription;

/**
 * @property    \Illuminate\Database\Eloquent\Relations\BelongsToMany   $subscriptions
 */
trait HasSubscriptions
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subscriptions()
    {
        return $this->belongsToMany(Subscription::class);
    }

    /**
     * @param Subscription $subscription
     * @return bool
     */
    public function hasSubscription(Subscription $subscription)
    {
        return $this->subscriptions->contains('id', $subscription->id);
    }

    /**
     * @param Subscription $subscription
     * @return Subscription
     */
    public function addSubscription(Subscription $subscription)
    {
        $subscription = $this->subscriptions()->save($subscription);

        return $subscription;
    }

}
