<?php

namespace App\Services\Stripe\Resources;


use App\Models\Account;
use App\Models\Card;
use App\Models\Plan;
use App\Models\Subscription;
use jamesvweston\Stripe\Requests\CreateSubscriptionItemRequest;
use jamesvweston\Stripe\Requests\CreateSubscriptionRequest;

class StripeSubscriptionResource extends BaseStripeResource
{

    /**
     * @param Account $account
     * @param Plan $plan
     * @return Subscription
     * @throws \jamesvweston\Stripe\Exceptions\StripeException
     */
    public function create (Account $account, Plan $plan)
    {
        $subscription_request           = new CreateSubscriptionRequest();
        $subscription_request->setCustomer($account->stripe_id);
        $subscription_request->setBilling('charge_automatically');

        $subscription_item_request      = new CreateSubscriptionItemRequest();
        $subscription_item_request->setPlan($plan->stripe_id);
        $subscription_request->setItems([$subscription_item_request]);

        $stripe_subscription            = $this->client->subscriptions->store($subscription_request);

        $subscription                   = new Subscription();
        $subscription->account_id       = $account->id;
        $subscription->plan_id          = $plan->id;
        $subscription->stripe_id        = $stripe_subscription->getId();
        $subscription->quantity         = $stripe_subscription->getQuantity();

        if (!is_null($stripe_subscription->getTrialEnd()))
            $subscription->trial_ends_at    = \Carbon\Carbon::createFromTimestamp($stripe_subscription->getTrialEnd());

        $subscription->save();
        return $subscription;
    }

    /**
     * @param Subscription $subscription
     * @return Subscription
     * @throws \jamesvweston\Stripe\Exceptions\StripeException
     */
    public function cancel (Subscription $subscription)
    {
        $this->client->subscriptions->delete($subscription->stripe_id);
        $subscription->cancelled_at     = now();
        $subscription->save();

        return $subscription;
    }
}
