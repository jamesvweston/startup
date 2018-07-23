<?php

namespace App\Http\Controllers;


use App\Http\Requests\Roles\GetRolesRequest;
use App\Models\Role;

class RoleController extends Controller
{

    public function index (GetRolesRequest $request)
    {
        $qb                             = Role::query();

        if (!is_null($request->ids))
            $qb->whereIn('id', explode(',', $request->ids));

        if (!is_null($request->names))
            $qb->whereIn('name', explode(',', $request->names));

        $qb->orderBy($request->order_by, $request->direction);
        return $qb->paginate($request->per_page);
    }

}
