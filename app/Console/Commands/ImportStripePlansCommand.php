<?php

namespace App\Console\Commands;


use App\Services\Stripe\StripeService;
use Illuminate\Console\Command;

class ImportStripePlansCommand extends Command
{

    protected $signature = 'stripe:plans:import';

    protected $description = 'Import stripe plans';

    /**
     * @var StripeService
     */
    protected $stripe_service;


    /**
     * @param StripeService $stripe_service
     */
    public function __construct(StripeService $stripe_service)
    {
        parent::__construct();
        $this->stripe_service           = $stripe_service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $plan_response              = $this->stripe_service->getClient()->plans->get();
        foreach ($plan_response->getData() AS $stripe_plan)
        {
            $this->stripe_service->plans->import($stripe_plan);
        }
    }
}
