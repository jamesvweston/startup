<?php

namespace App\Http\Requests\Subscriptions;


use App\Models\Account;
use App\Models\Card;
use App\Models\Plan;
use App\Traits\HashesValues;
use App\Traits\ValidatesAccess;
use App\Traits\ValidatesResources;
use Illuminate\Foundation\Http\FormRequest;

class CreateSubscriptionRequest extends FormRequest
{
    use HashesValues, ValidatesAccess, ValidatesResources;

    /**
     * @var Account
     */
    public $account;

    /**
     * @var Plan
     */
    public $plan;

    protected function prepareForValidation()
    {
        $this->merge([
            'account_id' => $this->decodeHash($this->input('account_id')),
            'plan_id'   => $this->decodeHash($this->input('plan_id'))
        ]);
    }

    public function authorize()
    {
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
            'account_id'                => 'required',
            'plan_id'                   => 'required',
        ];
    }

    /**
     * @param  \Illuminate\Validation\Validator $validator
     */
    public function withValidator ($validator)
    {
        $validator->after(function () use ($validator)
        {
            if (empty($validator->failed()))
            {
                $this->account                  = $this->findAccount($this->input('account_id'));
                $this->userHasAccount(\Auth::user(), $this->account, true);

                $this->accountHasCards($this->account, true);

                $this->plan                     = $this->findPlan($this->input('plan_id'));
                $this->planCanBeAddedToSubscriptions($this->plan);
            }
        });
    }

}
