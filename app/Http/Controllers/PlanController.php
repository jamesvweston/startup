<?php

namespace App\Http\Controllers;


use App\Http\Requests\Plans\CreatePlanRequest;
use App\Http\Requests\Plans\DeletePlanRequest;
use App\Http\Requests\Plans\GetPlansRequest;
use App\Http\Requests\Plans\ShowPlanRequest;
use App\Http\Requests\Plans\UpdatePlanRequest;
use App\Traits\ValidatesResources;
use App\Models\Plan;
use App\Services\Stripe\StripeService;
use DB;
use jamesvweston\Stripe\Requests\CreateProductRequest;

class PlanController extends Controller
{

    use ValidatesResources;

    /**
     * @var StripeService
     */
    private $stripe_service;


    public function __construct(StripeService $stripe_service)
    {
        $this->stripe_service           = $stripe_service;
    }

    public function index(GetPlansRequest $request)
    {
        $qb                             = Plan::query();

        if (!is_null($request->ids))
            $qb->whereIn('id', explode(',', $request->ids));

        $qb->orderBy($request->order_by, $request->direction);
        return $qb->paginate($request->per_page);
    }

    public function store(CreatePlanRequest $request)
    {
        $plan                           = $this->stripe_service->plans->create($request->toArray());
        return response($plan, 201);
    }

    public function show(ShowPlanRequest $request)
    {
        $plan                           = $request->plan;
        return $plan;
    }

    public function update(UpdatePlanRequest $request)
    {
        $plan                           = $request->plan;
        $plan                           = $this->stripe_service->plans->update($plan, $request->toArray());

        return $plan;
    }

    public function destroy(DeletePlanRequest $request)
    {
        $plan                           = $request->plan;
        $this->stripe_service->plans->delete($plan);

        return response(null, 204);
    }

}
