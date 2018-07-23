<?php

namespace App\Http\Controllers;

use App\Events\SubscriptionCancelledEvent;
use App\Events\SubscriptionCreatedEvent;
use App\Http\Requests\Subscriptions\CancelSubscriptionRequest;
use App\Http\Requests\Subscriptions\CreateSubscriptionRequest;
use App\Http\Requests\Subscriptions\GetSubscriptionsRequest;
use App\Http\Requests\Subscriptions\ShowSubscriptionRequest;
use App\Models\Subscription;
use App\Services\Stripe\StripeService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    /**
     * @var StripeService
     */
    private $stripe_service;


    public function __construct(StripeService $stripe_service)
    {
        $this->stripe_service           = $stripe_service;
    }


    public function index(GetSubscriptionsRequest $request)
    {
        $qb                             = Subscription::query();
        $qb
            ->whereIn('account_id', $request->account_ids)
            ->orderBy($request->order_by, $request->direction);

        return $qb->paginate($request->per_page);
    }


    public function store(CreateSubscriptionRequest $request)
    {
        $subscription           = $this->stripe_service->subscriptions->create($request->account, $request->plan);
        event(new SubscriptionCreatedEvent($subscription->id));

        return response($subscription, 201);
    }

    public function show (ShowSubscriptionRequest $request)
    {
        $subscription           = $request->subscription;
        return $subscription;
    }

    public function destroy (CancelSubscriptionRequest $request)
    {
        $subscription           = $request->subscription;
        $this->stripe_service->subscriptions->cancel($subscription);

        event(new SubscriptionCancelledEvent($subscription->id));
        return $subscription;
    }
}
