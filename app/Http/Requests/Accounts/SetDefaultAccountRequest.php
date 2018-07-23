<?php

namespace App\Http\Requests\Accounts;


use App\Models\Account;
use App\Traits\HashesValues;
use App\Traits\ValidatesAccess;
use App\Traits\ValidatesResources;
use Illuminate\Foundation\Http\FormRequest;

class SetDefaultAccountRequest extends FormRequest
{

    use HashesValues, ValidatesAccess, ValidatesResources;

    /**
     * @var Account
     */
    public $account;


    protected function prepareForValidation()
    {
        $this->route()->setParameter('id',  $this->decodeHash($this->route('id')));
    }

    public function authorize()
    {
        $this->account                  = $this->findAccount($this->route('id'));
        $this->userHasAccount(\Auth::user(), $this->account, true);

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
