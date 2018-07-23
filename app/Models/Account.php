<?php

namespace App\Models;


use App\Traits\HasCards;
use App\Traits\HashesValues;
use App\Traits\HasSubscriptions;
use App\Traits\HasTeams;
use Illuminate\Database\Eloquent\Model;

/**
 * @property    int                             $id
 * @property    string                          name
 * @property    int                             $owner_id
 * @property    string                          $stripe_id
 * @property    \Carbon\Carbon                  $created_at
 * @property    \Carbon\Carbon                  $updated_at
 *
 * @property    User                            $owner
 */
class Account extends Model
{

    use HasCards, HashesValues, HasSubscriptions, HasTeams;


    protected $with = ['owner'];

    protected $dates = ['created_at', 'updated_at',];


    /**
     * @return \Illuminate\Support\Carbon
     */
    public static function getDefaultTrialEndsAt ()
    {
        return now()->addDays(10);
    }

    /**
     * @return array
     */
    public function toArray ()
    {
        return [
            'id' => $this->encodeValue($this->id),
            'name' => $this->name,
            'owner' => $this->owner->toArray(),
        ];
    }

}
