<?php

namespace App\Models;


use App\Traits\HashesValues;
use Illuminate\Database\Eloquent\Model;

/**
 * @property    int                             $id
 * @property    string|null                     $nickname
 * @property    int                             $amount
 * @property    string                          $currency
 * @property    string                          $stripe_id
 * @property    string                          $stripe_product_id
 * @property    string|null                     $billing_scheme
 * @property    string|null                     $interval
 * @property    int|null                        $interval_count
 * @property    string|null                     $usage_type
 * @property    boolean                         $is_active
 */
class Plan extends Model
{

    use HashesValues;

    public $timestamps = false;

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * @return array
     */
    public function toArray()
    {
        $object['id']                   = $this->encodeValue($this->id);
        $object['nickname']             = $this->nickname;
        $object['amount']               = $this->amount;
        $object['currency']             = $this->currency;
        $object['billing_scheme']       = $this->billing_scheme;
        $object['interval']             = $this->interval;
        $object['interval_count']       = $this->interval_count;
        $object['usage_type']           = $this->usage_type;
        $object['is_active']            = $this->is_active;

        return $object;
    }

}
