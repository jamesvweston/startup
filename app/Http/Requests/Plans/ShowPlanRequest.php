<?php

namespace App\Http\Requests\Plans;

use App\Models\Plan;
use App\Traits\HashesValues;
use App\Traits\ValidatesAccess;
use App\Traits\ValidatesResources;
use Illuminate\Foundation\Http\FormRequest;

class ShowPlanRequest extends FormRequest
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
        $this->plan                 = $this->findPlan($this->route('id'));

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
            //
        ];
    }
}
