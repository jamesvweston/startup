<?php

namespace App\Models;


use App\Traits\HashesValues;
use Illuminate\Database\Eloquent\Model;

/**
 * @property    int                             $id
 * @property    string                          $name
 * @property    int                             $last4
 * @property    int                             $exp_month
 * @property    string|null                     $exp_year
 * @property    string                          $brand
 * @property    string                          $funding
 * @property    bool                            $is_default
 * @property    string|null                     $address_zip
 * @property    int                             $account_id
 * @property    int                             $country_id
 * @property    string                          $stripe_id
 * @property    \Carbon\Carbon                  $created_at
 * @property    \Carbon\Carbon                  $updated_at
 *
 * @property    Country                         $country
 * @property    Account                         $account
 */
class Card extends Model
{

    use HashesValues;


    protected $casts = [
        'is_default' => 'boolean',
    ];

    protected $dates = ['created_at', 'updated_at'];


    protected $with = ['country'];


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
    public function country ()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $object['id']                   = $this->encodeValue($this->id);
        $object['name']                 = $this->name;
        $object['last4']                = $this->last4;
        $object['exp_month']            = $this->exp_month;
        $object['exp_year']             = $this->exp_year;
        $object['brand']                = $this->brand;
        $object['funding']              = $this->funding;
        $object['address_zip']          = $this->address_zip;
        $object['is_default']           = $this->is_default;
        $object['country']              = $this->country->toArray();

        return $object;
    }

}
