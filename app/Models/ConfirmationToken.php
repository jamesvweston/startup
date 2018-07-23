<?php

namespace App\Models;


use App\Traits\HashesValues;
use Illuminate\Database\Eloquent\Model;

/**
 * @property    int                             $id
 * @property    int                             $user_id
 * @property    string                          $token
 * @property    \Carbon\Carbon                  $expires_at
 *
 * @property    User                            $user
 */
class ConfirmationToken extends Model
{

    use HashesValues;

    public $timestamps = false;

    protected $with = ['user'];

    protected $fillable = [
        'token',
        'expires_at',
    ];

    public static function boot()
    {
        static::creating(function ($token) {
            optional($token->user->confirmationToken)->delete();
        });
    }

    public function getRouteKeyName()
    {
        return 'token';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return bool
     */
    public function hasExpired()
    {
        return $this->freshTimestamp()->gt($this->expires_at);
    }

    public function toArray()
    {
        $object['id']                   = $this->encodeValue($this->id);
        $object['token']                = $this->token;
        $object['expires_at']           = $this->expires_at;
        $object['user']                 = $this->user->toArray();
    }
}
