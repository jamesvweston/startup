<?php

namespace App\Http\Requests\Cards;


use App\Traits\HashesValues;
use App\Traits\ValidatesAccess;
use App\Traits\ValidatesResources;
use App\Models\Account;
use Illuminate\Foundation\Http\FormRequest;

class CreateCardRequest extends FormRequest
{

    use HashesValues, ValidatesAccess, ValidatesResources;

    /**
     * @var Account
     */
    public $account;


    protected function prepareForValidation()
    {
        $this->merge([
            'account_id' => $this->decodeHash($this->input('account_id')),
            'country_id' => $this->decodeHash($this->input('country_id'))
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
            'account_id'                    => 'required',
            'name'                          => 'required|string|max:255',
            'number'                        => 'required|numeric',
            'cvc'                           => 'required|numeric',
            'exp_month'                     => 'required|in:01,02,03,04,05,06,07,08,09,10,11,12',
            'exp_year'                      => 'required|numeric',
            'address_zip'                   => 'required|numeric',
            'country_id'                    => 'required|exists:countries,id',
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
            }
        });
    }

}
