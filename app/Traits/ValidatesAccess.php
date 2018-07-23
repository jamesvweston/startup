<?php

namespace App\Traits;


use App\Models\Card;
use App\Models\Account;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\TeamInvite;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ValidatesAccess
{

    /**
     * @param User $user
     * @param Account $account
     * @param bool $throws
     * @return bool
     */
    private function userHasAccount (User $user, Account $account, $throws = false)
    {
        $err                    = !$user->hasAccount($account);
        if ($err && $throws)
            throw new AccessDeniedHttpException('Cannot access provided account');

        return $err;
    }

    private function accountHasCard (Account $account, Card $card, $throws = false)
    {
        $err                    = !$account->hasCard($card);
        if ($err && $throws)
            throw new AccessDeniedHttpException('Card does not belong to account');

        return $err;
    }

    /**
     * @param User $user
     * @param bool $throws
     * @return bool
     */
    private function authHasUser (User $user, $throws = false)
    {
        $err                    = \Auth::user()->id != $user->id;
        if ($err && $throws)
            throw new AccessDeniedHttpException('Cannot access provided user');

        return $err;
    }


    private function userCanModifyPlans (User $user, $throws = false)
    {

    }


    private function teamHasInvitedUser (Account $account, User $user, $throws = false)
    {
        $err                    = is_null($account->invitations()->newQuery()->where('email', '=', $user->email)->first());

        if ($err && $throws)
            throw new AccessDeniedHttpException('User has not been invited to this team');

        return $err;
    }


    private function userOwnsTeamInvite (User $user, TeamInvite $team_invite, $throws = false)
    {
        $err                    = $user->id != $team_invite->created_by_id;
        if ($err && $throws)
            throw new AccessDeniedHttpException('User did not originally create invitation');

        return $err;
    }

    private function planCanBeAddedToSubscriptions (Plan $plan, $throws = false)
    {
        $err                    = !$plan->is_active;
        if ($err && $throws)
            throw new AccessDeniedHttpException('Plan cannot be added to subscriptions');

        return $err;
    }

    private function accountHasCards (Account $account, $throws = false)
    {
        $err                    = $account->cards()->count() == 0;
        if ($err && $throws)
            throw new AccessDeniedHttpException('Account has no cards on record');

        return $err;
    }

    /**
     * @param Subscription $subscription
     * @param bool $throws
     * @return bool
     */
    private function canCancelSubscription (Subscription $subscription, $throws = false)
    {
        $err                    = !is_null($subscription->cancelled_at);
        if ($err && $throws)
            throw new AccessDeniedHttpException('Subscription has already been cancelled');

        return $err;
    }
}
