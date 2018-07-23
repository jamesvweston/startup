<?php

namespace App\Http\Controllers;


use App\Events\AccountCreatedEvent;
use App\Events\UserEmailConfirmationResendEvent;
use App\Events\UserUpdatedEmailEvent;
use App\Events\UserCreatedEvent;
use App\Events\UserUpdatedEvent;
use App\Http\Requests\Users\ConfirmEmailTokenRequest;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdatePasswordRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Traits\ValidatesResources;
use App\Models\Account;
use App\Models\User;

class UserController extends Controller
{

    use ValidatesResources;


    public function store(CreateUserRequest $request)
    {
        list($account, $user) = \DB::transaction(function () use ($request)
        {
            $user                           = new User();
            $user->first_name               = $request->first_name;
            $user->last_name                = $request->last_name;
            $user->email                    = $request->email;
            $user->setPassword($request->password);
            $user->save();

            $account                        = new Account();
            $account->name                  = $request->account['name'];
            $account->owner_id              = $user->id;
            $account->save();

            $user->addAccount($account);

            return [$account, $user];
        });

        event(new UserCreatedEvent($user->id));
        event(new AccountCreatedEvent($account->id));
        return response($user, 201);
    }

    public function update (UpdateUserRequest $request)
    {
        $user                               = $request->user;
        $email_changed                      = !is_null($request->email) && $request->email != $user->email;

        $user = \DB::transaction(function () use ($request, $user)
        {
            if (!is_null($request->first_name))
                $user->first_name               = $request->first_name;

            if (!is_null($request->last_name))
                $user->last_name               = $request->last_name;

            if (!is_null($request->email))
                $user->email               = $request->email;

            $user->save();

            return $user;
        });

        if ($email_changed)
            event(new UserUpdatedEmailEvent($user->id));

        event(new UserUpdatedEvent($user->id));

        return $user;
    }

    public function updatePassword (UpdatePasswordRequest $request)
    {
        $user                               = $request->user;

        $user = \DB::transaction(function () use ($request, $user)
        {
            $user->setPassword($request->new_password);
            $user->save();

            return $user;
        });

        return $user;
    }

    public function confirmEmail (ConfirmEmailTokenRequest $request)
    {
        $request->confirmation_token->user->confirmEmail();
    }

    public function resendConfirmationEmail ()
    {
        event(new UserEmailConfirmationResendEvent(\Auth::user()->id));
    }

}
