<?php

namespace App\Traits;


use App\Models\Account;


/**
 * @property    \Illuminate\Database\Eloquent\Relations\BelongsToMany   $accounts
 */
trait HasAccounts
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accounts()
    {
        return $this->belongsToMany(Account::class)->withPivot('role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ownedAccounts()
    {
        return $this->hasMany(Account::class, 'owner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function currentAccount()
    {
        return $this->hasOne(Account::class, 'id', 'current_account_id');
    }

    /**
     * @param Account $account
     * @return bool
     */
    public function hasAccount(Account $account)
    {
        return $this->accounts->contains('id', $account->id);
    }

    /**
     * @param Account $account
     * @return bool
     */
    public function ownsAccount (Account $account)
    {
        return ($this->ownedAccounts()
            ->where('id', $account->id)->first()
        ) ? true : false;
    }

    /**
     * @param Account $account
     * @return Account
     */
    public function addAccount(Account $account)
    {
        $account = $this->accounts()->save($account);

        if (is_null($this->current_account_id))
            $this->setCurrentAccount($account);

        return $account;
    }

    /**
     * @param Account $account
     */
    public function setCurrentAccount(?Account $account)
    {
        $this->current_account_id = optional($account)->id;
        $this->save();
    }

}
