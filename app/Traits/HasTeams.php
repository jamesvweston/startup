<?php

namespace App\Traits;


use App\Models\TeamInvite;
use App\Models\User;

/**
 * @property \Illuminate\Database\Eloquent\Relations\HasMany    $invitations
 * @property \Illuminate\Database\Eloquent\Relations\HasMany    $members
 */
trait HasTeams
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(User::class)->withPivot('role');
    }

    /**
     * @param User $user
     * @param array $pivotData
     */
    public function addMember(User $user, $pivotData)
    {
        $this->members()->attach($user, $pivotData);

        $team_invite = $this->invitations()->newQuery()->where('email', '=', $user->email)->first();
        if (!is_null($team_invite))
        {
            $team_invite->joined_at = now();
            $team_invite->save();
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invitations ()
    {
        return $this->hasMany(TeamInvite::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isMember(User $user)
    {
        return $this->members()->where('user_id', $user->id)->first() ? true : false;
    }

    /**
     * @param User      $user
     * @param string    $role
     * @return bool
     */
    public function hasRole(User $user, $role)
    {
        return $this->members()->where('user_id', $user->id)
            ->where('role', $role)->first() ? true : false;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isOwner(User $user)
    {
        return $this->owner()->where('id', $user->id)->first() ? true : false;
    }

}
