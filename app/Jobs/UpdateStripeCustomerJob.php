<?php

namespace App\Jobs;

use App\Models\Account;
use App\Services\Stripe\StripeService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateStripeCustomerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * @var int
     */
    private $account_id;


    /**
     * @param int   $account_id
     */
    public function __construct($account_id)
    {
        $this->account_id           = $account_id;
    }

    /**
     * @param StripeService $stripe_service
     */
    public function handle(StripeService $stripe_service)
    {
        $account                    = Account::find($this->account_id);
        $stripe_service->customers->update($account);
    }
}
