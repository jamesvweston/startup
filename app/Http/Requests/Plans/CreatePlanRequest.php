<?php

namespace App\Http\Requests\Plans;


use App\Traits\ValidatesAccess;
use Illuminate\Foundation\Http\FormRequest;

class CreatePlanRequest extends FormRequest
{

    use ValidatesAccess;


    public function authorize()
    {
        $this->userCanModifyPlans(\Auth::user(), true);

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nickname'                  => 'nullable|string',
            'amount'                    => 'required|integer',
            'stripe_id'                 => 'nullable|string|max:100|unique:plans',
            'billing_scheme'            => 'nullable|string|in:per_unit,tiered',
            'currency'                  => 'nullable|string',
            'interval'                  => 'required|string|in:day,week,month,year',
            'interval_count'            => 'nullable|integer',
            'is_active'                 => 'nullable|boolean',
            'usage_type'                => 'nullable|string|in:licensed,metered',

            'product'                   => 'required|array',
            'product.id'                => 'required_without:product.name|string',
            'product.name'              => 'required_without:product.id|string',
        ];
    }
}
