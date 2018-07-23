<?php

namespace App\Models;


use App\Traits\HashesValues;
use Illuminate\Database\Eloquent\Model;

/**
 * @property    int                             $id
 * @property    string                          $street1
 * @property    string|null                     $street2
 * @property    string                          $city
 * @property    string                          $postal_code
 * @property    string|null                     $phone
 * @property    string                          $state_province
 * @property    int                             $country_id
 * @property    \Carbon\Carbon                  $created_at
 * @property    \Carbon\Carbon                  $updated_at
 *
 * @property    Country                         $country
 */
class Address extends Model
{

    use HashesValues;

    protected $with = ['country'];

    protected $fillable = [
        'street1',
        'street2',
        'city',
        'postal_code',
        'phone',
        'state_province',
        'country_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    /**
     * @return array
     */
    public function jsonSerialize ()
    {
        $object['id']                   = $this->encodeValue($this->id);
        $object['street1']              = $this->street1;
        $object['street2']              = $this->street2;
        $object['city']                 = $this->city;
        $object['postal_code']          = $this->postal_code;
        $object['phone']                = $this->phone;
        $object['state_province']       = $this->state_province;
        $object['country']              = $this->country->toArray();

        return $object;
    }

}
