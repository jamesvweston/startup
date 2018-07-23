<?php

namespace App\Http\Controllers;


use App\Events\TeamInviteAcceptedEvent;
use App\Events\TeamInviteCreatedEvent;
use App\Http\Requests\TeamInvites\AcceptTeamInviteRequest;
use App\Http\Requests\TeamInvites\CreateTeamInviteRequest;
use App\Http\Requests\TeamInvites\DeleteTeamInviteRequest;
use App\Http\Requests\TeamInvites\GetTeamInvites;
use App\Models\TeamInvite;
use DB;

class TeamInviteController extends Controller
{

    public function index (GetTeamInvites $request)
    {
        $qb                     = TeamInvite::query();
        $qb->where(function ($qb) use ($request)
        {
            $qb
                ->orWhereIn('account_id', $request->account_ids)
                ->orWhere('email', '=', \Auth::user()->email);
        });

        if (!is_null($request->emails))
            $qb->whereIn('email', explode(',', $request->emails));


        $invitations            = $qb->orderBy($request->order_by, $request->direction)
            ->paginate($request->per_page);

        return $invitations;
    }

    public function store (CreateTeamInviteRequest $request)
    {
        $team_invite = DB::transaction(function () use ($request)
        {
            $team_invite            = new TeamInvite();
            $team_invite->email     = $request->email;
            $team_invite->role      = $request->role;
            $team_invite->created_by_id = \Auth::user()->id;

            $team_invite            = $request->account->invitations()->save($team_invite);
            return $team_invite;
        });

        event(new TeamInviteCreatedEvent($team_invite->id));

        return response($team_invite, 201);
    }

    public function destroy (DeleteTeamInviteRequest $request)
    {
        $team_invite                = $request->invitation;
        DB::transaction(function () use ($team_invite)
        {
            $team_invite->delete();
        });
        return response(null, 204);
    }

    public function accept (AcceptTeamInviteRequest $request)
    {
        $team_invite = DB::transaction(function () use ($request)
        {
            $account                = $request->account;
            $team_invite            = $request->invitation;

            $pivot_data             = ['role' => $team_invite->role];
            $account->addMember(\Auth::user(), $pivot_data);

            return $team_invite;
        });

        event(new TeamInviteAcceptedEvent($team_invite->id));

        return response($team_invite, 201);
    }

}
