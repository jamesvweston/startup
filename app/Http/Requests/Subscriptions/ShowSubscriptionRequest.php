<?php

namespace App\Http\Requests\Subscriptions;

use App\Models\Subscription;
use App\Traits\HashesValues;
use App\Traits\ValidatesAccess;
use App\Traits\ValidatesResources;
use Illuminate\Foundation\Http\FormRequest;

class ShowSubscriptionRequest extends FormRequest
{

    use HashesValues, ValidatesAccess, ValidatesResources;


    /**
     * @var Subscription
     */
    public $subscription;


    protected function prepareForValidation()
    {
        $this->route()->setParameter('id',  $this->decodeHash($this->route('id')));
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
            //
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
                $this->subscription                  = $this->findSubscription($this->route('id'));
                $this->userHasAccount(\Auth::user(), $this->subscription->account, true);
            }
        });
    }

}
