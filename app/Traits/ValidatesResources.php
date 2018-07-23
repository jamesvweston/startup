<?php

namespace App\Traits;


use App\Models\Card;
use App\Models\Plan;
use App\Models\Account;
use App\Models\ConfirmationToken;
use App\Models\Subscription;
use App\Models\TeamInvite;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ValidatesResources
{

    /**
     * @param int   $id
     * @return Account
     */
    private function findAccount ($id)
    {
        $account                        = Account::find($id);
        if (is_null($account))
            throw new NotFoundHttpException('Account not found');

        return $account;
    }

    /**
     * @param int   $id
     * @return Card
     */
    private function findCard ($id)
    {
        $card                           = Card::find($id);
        if (is_null($card))
            throw new NotFoundHttpException('Card not found');

        return $card;
    }

    /**
     * @param int   $id
     * @return TeamInvite
     */
    private function findTeamInvite ($id)
    {
        $invitation                     = TeamInvite::find($id);
        if (is_null($invitation))
            throw new NotFoundHttpException('TeamInvite not found');

        return $invitation;
    }

    /**
     * @param int   $id
     * @return User
     */
    private function findUser ($id)
    {
        $user                           = User::find($id);
        if (is_null($user))
            throw new NotFoundHttpException('User not found');

        return $user;
    }

    /**
     * @param int   $id
     * @return Plan
     */
    private function findPlan ($id)
    {
        $plan                           = Plan::find($id);
        if (is_null($plan))
            throw new NotFoundHttpException('Plan not found');

        return $plan;
    }

    /**
     * @param int   $id
     * @return ConfirmationToken
     */
    private function findConfirmationToken ($id)
    {
        $confirmation_token           = ConfirmationToken::query()->where('token', '=', $id)->first();
        if (is_null($confirmation_token))
            throw new NotFoundHttpException('ConfirmationToken not found');

        return $confirmation_token;
    }

    /**
     * @param int   $id
     * @return Subscription
     */
    private function findSubscription ($id)
    {
        $subscription                   = Subscription::find($id);
        if (is_null($subscription))
            throw new NotFoundHttpException('Subscription not found');

        return $subscription;
    }

}
