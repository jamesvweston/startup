<?php

namespace App\Services\Stripe\Resources;


use App\Models\Plan;
use DB;
use jamesvweston\Stripe\Requests\CreatePlanRequest;
use jamesvweston\Stripe\Requests\CreateProductRequest;
use jamesvweston\Stripe\Requests\UpdatePlanRequest;
use jamesvweston\Stripe\Responses\Plan AS StripePlan;

class StripePlanService extends BaseStripeResource
{

    /**
     * @param array $request
     * @return Plan
     * @throws \jamesvweston\Stripe\Exceptions\StripeException
     */
    public function create ($request)
    {
        $plan                           = new Plan();
        $plan->nickname                 = $request['nickname'];
        $plan->amount                   = $request['amount'];
        $plan->stripe_id                = isset($request['stripe_id']) ? $request['stripe_id'] : null;
        $plan->billing_scheme           = isset($request['billing_scheme']) ? $request['billing_scheme'] : 'per_unit';
        $plan->currency                 = isset($request['currency']) ? $request['currency'] : 'USD';
        $plan->interval                 = $request['interval'];
        $plan->interval_count           = isset($request['interval_count']) ? $request['interval_count'] : null;
        $plan->usage_type               = isset($request['usage_type']) ? $request['usage_type'] : 'licensed';
        $plan->is_active                = isset($request['is_active']) ? $request['is_active'] : true;

        if (isset($request['product']['id']) && sizeof($request['product']) == 1)
            $product_request            = $request['product']['id'];
        else
        {
            $product_request            = new CreateProductRequest();

            if (isset($request['product']['id']))
                $product_request->setId($request['product']['id']);

            $product_request->setName($request['product']['name']);
        }

        $request                    = new CreatePlanRequest();
        $request->setId($plan->stripe_id);
        $request->setNickname($plan->nickname);
        $request->setAmount($plan->amount);
        $request->setBillingScheme($plan->billing_scheme);
        $request->setCurrency('USD');
        $request->setInterval($plan->interval);
        $request->setIntervalCount($plan->interval_count);
        $request->setUsageType($plan->usage_type);
        $request->setProduct($product_request);
        //  $request->setActive($plan->is_active);

        $stripe_plan                = $this->client->plans->create($request);

        $plan->stripe_id            = $stripe_plan->getId();
        $plan->stripe_product_id    = $stripe_plan->getProduct();

        try
        {
            DB::transaction(function () use ($plan)
            {
                $plan->save();
                //  TODO: Delete the product if it was just created
            });
        }
        catch (\Exception $exception)
        {
            $this->client->plans->delete($stripe_plan->getId());
        }


        return $plan;
    }

    /**
     * @param Plan $plan
     * @param array $request
     * @return Plan
     * @throws \jamesvweston\Stripe\Exceptions\StripeException
     */
    public function update (Plan $plan, $request)
    {
        $update_plan_request            = new UpdatePlanRequest();

        if (isset($request['is_active']))
        {
            //  $plan->is_active            = $request['is_active'];
            //  $update_plan_request->setActive($plan->is_active);
            //  TODO: Guzzle converts boolean to 0 or 1. This causes the API call to fail. Need to figure out why this is happening
        }

        if (isset($request['nickname']))
        {
            $plan->nickname             = $request['nickname'];
            $update_plan_request->setNickname($plan->nickname);
        }

        if (isset($request['stripe_product_id']))
        {
            $plan->stripe_product_id    = $request['stripe_product_id'];
            $update_plan_request->setProduct($plan->stripe_product_id);
        }


        DB::transaction(function () use ($plan, $update_plan_request)
        {
            $stripe_plan                = $this->client->plans->update($update_plan_request, $plan->stripe_id);
            $plan->save();
        });
        return $plan;
    }

    /**
     * @param Plan $plan
     * @throws \jamesvweston\Stripe\Exceptions\StripeException
     */
    public function delete (Plan $plan)
    {
        DB::transaction(function () use ($plan) {
            $this->client->plans->delete($plan->stripe_id);
            $plan->delete();
        });
    }

    /**
     * @param StripePlan $stripe_plan
     * @return Plan
     */
    public function import (StripePlan $stripe_plan): Plan
    {
        $plan                       = Plan::query()->where('stripe_id', '=', $stripe_plan->getId())->first();
        if (is_null($plan))
            $plan                   = new Plan();

        $plan->nickname             = $stripe_plan->getNickname();
        $plan->amount               = $stripe_plan->getAmount();
        $plan->currency             = $stripe_plan->getCurrency();
        $plan->stripe_id            = $stripe_plan->getId();
        $plan->stripe_product_id    = $stripe_plan->getProduct();
        $plan->billing_scheme       = $stripe_plan->getBillingScheme();
        $plan->interval             = $stripe_plan->getInterval();
        $plan->interval_count       = $stripe_plan->getIntervalCount();
        $plan->usage_type           = $stripe_plan->getUsageType();
        $plan->is_active            = $stripe_plan->getActive();


        $plan->save();

        return $plan;
    }

}
