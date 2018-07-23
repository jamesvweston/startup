<?php

namespace App\Services\Stripe\Resources;


use jamesvweston\Stripe\StripeClient;

class BaseStripeResource
{

    /**
     * @var StripeClient
     */
    protected $client;


    public function __construct(StripeClient $client)
    {
        $this->client               = $client;
    }
}
