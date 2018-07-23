<?php

namespace App\Models;


use App\Traits\HashesValues;
use Illuminate\Database\Eloquent\Model;


/**
 * @property    int                             $id
 * @property    string                          $email
 * @property    string                          $role
 * @property    int                             $account_id
 * @property    int                             $created_by_id
 * @property    \Carbon\Carbon|null             $joined_at
 * @property    \Carbon\Carbon                  $created_at
 * @property    \Carbon\Carbon                  $updated_at
 *
 * @property    Account                         $account
 * @property    User                            $created_by
 */
class TeamInvite extends Model
{

    use HashesValues;

    protected $dates = ['joined_at', 'created_at', 'updated_at',];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function created_by()
    {
        return $this->hasOne(User::class, 'id', 'created_by_id');
    }

    /**
     * @return array
     */
    public function toArray ()
    {
        $object['id']                   = $this->encodeValue($this->id);
        $object['email']                = $this->email;
        $object['role']                 = $this->role;
        $object['account_id']           = $this->account_id;
        $object['created_by']           = $this->created_by->toArray();
        $object['joined_at']            = $this->joined_at;
        $object['created_at']           = $this->created_at;
        $object['updated_at']           = $this->updated_at;

        return $object;
    }
}
