<?php

namespace App\Models;


use App\Traits\HasAccounts;
use App\Traits\HasConfirmationTokens;
use App\Traits\HashesValues;
use Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * @property    int                             $id
 * @property    string                          $first_name
 * @property    string                          $last_name
 * @property    string                          $email
 * @property    string                          $password
 * @property    string|null                     $remember_token
 * @property    bool                            $email_confirmed
 * @property    int|null                        $current_account_id
 * @property    \Carbon\Carbon                  $created_at
 * @property    \Carbon\Carbon                  $updated_at
 *
 * @property    Account|null                    $currentAccount
 */
class User extends Authenticatable
{

    use HashesValues, Notifiable, HasAccounts, HasApiTokens, HasConfirmationTokens;


    public function setPassword ($password)
    {
        $this->password             = Hash::make($password);
    }

    /**
     * @param string    $password
     * @return bool
     */
    public function passwordEquals ($password)
    {
        return Hash::check($password, $this->password);
    }

    /**
     * @return array
     */
    public function toArray ()
    {
        $object['id']               = $this->encodeValue($this->id);
        $object['first_name']       = $this->first_name;
        $object['last_name']        = $this->last_name;
        $object['email']            = $this->email;

        if (!is_null($this->pivot))
            $object['role']         = $this->pivot->getAttributes()['role'];

        return $object;
    }
}
