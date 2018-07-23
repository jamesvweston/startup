<?php

namespace App\Http\Controllers;


use App\Events\AccountCreatedEvent;
use App\Events\AccountUpdatedEvent;
use App\Http\Requests\Accounts\CreateAccountRequest;
use App\Http\Requests\Accounts\GetAccountsRequest;
use App\Http\Requests\Accounts\GetAccountUsersRequest;
use App\Http\Requests\Accounts\GetDefaultAccountRequest;
use App\Http\Requests\Accounts\SetDefaultAccountRequest;
use App\Http\Requests\Accounts\ShowAccountRequest;
use App\Http\Requests\Accounts\UpdateAccountRequest;
use App\Models\Account;
use DB;

class AccountController extends Controller
{

    public function index(GetAccountsRequest $request)
    {
        $qb                             = Account::query();
        $qb
            ->whereIn('id', $request->ids)
            ->orderBy($request->order_by, $request->direction);

        return $qb->paginate($request->per_page);
    }

    public function store(CreateAccountRequest $request)
    {
        $account = DB::transaction(function () use ($request)
        {
            $user                       = \Auth::user();
            $account                    = new Account();
            $account->name              = $request->name;
            $account->owner_id          = $user->id;
            $user->addAccount($account);

            return $account;
        });

        event(new AccountCreatedEvent($account->id));

        return $account;
    }

    public function show(ShowAccountRequest $request)
    {
        $account                    = $request->account;
        return $account;
    }

    public function getDefaultAccount (GetDefaultAccountRequest $request)
    {
        $account                    = \Auth::user()->currentAccount;
        return $account;
    }

    public function setDefaultAccount (SetDefaultAccountRequest $request)
    {
        $account = DB::transaction(function () use ($request)
        {
            $account                    = $request->account;
            $user                       = \Auth::user();
            $user->setCurrentAccount($account);

            return $account;
        });

        return $account;
    }

    public function update(UpdateAccountRequest $request)
    {
        $account = DB::transaction(function () use ($request)
        {
            $account                    = $request->account;

            if (!is_null($request->name))
                $account->name          = $request->name;

            $account->save();

            return $account;
        });

        event(new AccountUpdatedEvent($account->id));

        return $account;
    }

    public function getUsers (GetAccountUsersRequest $request)
    {
        $qb                             = $request->account->members()->newQuery();

        if (!is_null($request->user_ids))
            $qb->whereIn('account_user.user_id', explode(',', $request->user_ids));

        $qb->orderBy($request->order_by, $request->direction);
        return $qb->paginate($request->per_page);
    }
}
