<?php

namespace App\Traits;


use App\Models\ConfirmationToken;

trait HasConfirmationTokens
{

    /**
     * @return string
     */
    public function createConfirmationToken()
    {
        $this->confirmationToken()->create([
            'token' => $token = str_random(config('startup.confirmation_token.length')),
            'expires_at' => $this->freshTimestamp()->addMinutes(config('startup.confirmation_token.expiry')),
        ]);

        return $token;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function confirmationToken()
    {
        return $this->hasOne(ConfirmationToken::class);
    }

    public function confirmEmail()
    {
        $this->email_confirmed = true;
        $this->save();

        $this->confirmationToken()->delete();
    }

}
