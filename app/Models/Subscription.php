<?php

namespace App\Models;


use App\Traits\HashesValues;
use Illuminate\Database\Eloquent\Model;


/**
 * @property    int                             $id
 * @property    int                             $account_id
 * @property    string                          $stripe_id
 * @property    int                             $plan_id
 * @property    int                             $quantity
 * @property    \Carbon\Carbon|null             $trial_ends_at
 * @property    \Carbon\Carbon|null             $ends_at
 * @property    \Carbon\Carbon|null             $cancelled_at
 * @property    \Carbon\Carbon                  $created_at
 * @property    \Carbon\Carbon                  $updated_at
 *
 * @property    Account                         $account
 * @property    Plan                            $plan
 */
class Subscription extends Model
{

    use HashesValues;

    protected $dates = ['trial_ends_at', 'ends_at', 'cancelled_at', 'created_at', 'updated_at',];

    protected $with = ['account', 'account.owner', 'plan'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account ()
    {
        return $this->belongsTo(Account::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan ()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * @return array
     */
    public function toArray ()
    {
        $object['id']                   = $this->encodeValue($this->id);
        $object['quantity']             = $this->quantity;
        $object['trial_ends_at']        = $this->trial_ends_at;
        $object['ends_at']              = $this->ends_at;
        $object['cancelled_at']         = $this->cancelled_at;
        $object['created_at']           = $this->created_at;
        $object['account']              = $this->account->toArray();
        $object['plan']                 = $this->plan->toArray();

        return $object;
    }

}
