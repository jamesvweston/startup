<?php

namespace App\Services\Stripe;


use App\Services\Stripe\Resources\StripeCustomerResource;
use App\Services\Stripe\Resources\StripePlanService;
use App\Services\Stripe\Resources\StripeSubscriptionResource;
use jamesvweston\Stripe\StripeClient;
use jamesvweston\Stripe\StripeConfiguration;

class StripeService
{

    /**
     * @var StripeConfiguration
     */
    protected $config;

    /**
     * @var StripeClient
     */
    protected $client;

    /**
     * @var StripePlanService
     */
    public $plans;

    /**
     * @var StripeCustomerResource
     */
    public $customers;

    /**
     * @var StripeSubscriptionResource
     */
    public $subscriptions;


    public function __construct()
    {
        $this->config               = new StripeConfiguration(config('services.stripe.key'), config('services.stripe.secret'));
        $this->client               = new StripeClient($this->config);

        $this->plans                = new StripePlanService($this->client);
        $this->customers            = new StripeCustomerResource($this->client);
        $this->subscriptions        = new StripeSubscriptionResource($this->client);
    }

    /**
     * @return StripeClient
     */
    public function getClient(): StripeClient
    {
        return $this->client;
    }

}
