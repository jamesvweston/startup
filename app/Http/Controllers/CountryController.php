<?php

namespace App\Http\Controllers;


use App\Http\Requests\Locations\GetCountriesRequest;
use App\Models\Country;

class CountryController extends Controller
{

    public function index (GetCountriesRequest $request)
    {
        $qb                             = Country::query();

        if (!is_null($request->ids))
            $qb->whereIn('id', explode(',', $request->ids));

        if (!is_null($request->codes))
            $qb->whereIn('code', explode(',', $request->codes));

        if (!is_null($request->names))
            $qb->whereIn('name', explode(',', $request->names));

        $qb->orderBy($request->order_by, $request->direction);
        return $qb->paginate($request->per_page);
    }

}
