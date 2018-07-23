<?php

namespace App\Http\Requests\Plans;


use App\Traits\HashesValues;
use App\Traits\ValidatesAccess;
use App\Traits\ValidatesResources;
use App\Models\Plan;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
{

    use HashesValues, ValidatesAccess, ValidatesResources;

    /**
     * @var Plan
     */
    public $plan;


    protected function prepareForValidation()
    {
        $this->route()->setParameter('id',  $this->decodeHash($this->route('id')));
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        $this->userCanModifyPlans(\Auth::user(), true);
        $this->plan                 = $this->findPlan($this->route('id'));

        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'active'                    => 'nullable|boolean',
            'nickname'                  => 'nullable|string',
            'stripe_product_id'         => 'nullable|string',
            //  'trial_period_days'         => 'nullable|integer',
        ];
    }

}
