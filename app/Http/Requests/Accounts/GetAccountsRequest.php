<?php

namespace App\Http\Requests\Accounts;


use App\Traits\HashesValues;
use App\Traits\PaginatesResults;
use Illuminate\Foundation\Http\FormRequest;

class GetAccountsRequest extends FormRequest
{

    use HashesValues, PaginatesResults;

    public $ids;

    protected function prepareForValidation()
    {
        $this->merge(['ids' => $this->decodeHash($this->input('ids'))]);

        if (is_null($this->input('ids')))
            $account_ids                    = \Auth::user()->accounts()->pluck('account_id')->toArray();
        else
            $account_ids    = \Auth::user()->accounts()->whereIn('account_id', explode(',', $this->input('ids')))->pluck('account_id')->toArray();

        $this->ids = $account_ids;

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
        return $this->getPaginationValidationRules('id,name');
    }
}
