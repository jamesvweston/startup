<?php

namespace App\Http\Requests\Subscriptions;

use App\Traits\HashesValues;
use App\Traits\PaginatesResults;
use Illuminate\Foundation\Http\FormRequest;

class GetSubscriptionsRequest extends FormRequest
{

    use HashesValues, PaginatesResults;

    /**
     * @var string
     */
    public $account_ids;

    protected function prepareForValidation()
    {
        $this->merge([
            'ids' => $this->decodeHash($this->input('ids')),
            'account_ids' => $this->decodeHash($this->input('account_ids'))
        ]);

        if (is_null($this->input('account_ids')))
            $account_ids                    = \Auth::user()->accounts()->pluck('account_id')->toArray();
        else
            $account_ids    = \Auth::user()->accounts()->whereIn('account_id', explode(',', $this->input('account_ids')))->pluck('account_id')->toArray();

        $this->account_ids = $account_ids;
        $this->setDefaultPagination();
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
        return $this->getPaginationValidationRules('id');
    }
}
