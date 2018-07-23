<?php

namespace App\Http\Requests\Cards;


use App\Http\Requests\BaseRequest;
use App\Traits\HashesValues;
use App\Traits\ValidatesAccess;
use App\Traits\ValidatesResources;
use App\Models\Card;
use App\Models\Account;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCardRequest extends FormRequest
{
    use HashesValues, ValidatesAccess, ValidatesResources;

    /**
     * @var Account
     */
    public $account;

    /**
     * @var Card
     */
    public $card;


    protected function prepareForValidation()
    {
        $this->route()->setParameter('id',  $this->decodeHash($this->route('id')));
    }

    public function authorize()
    {
        $this->card                 = $this->findCard($this->route('id'));
        $this->account              = $this->card->account;
        $this->userHasAccount(\Auth::user(), $this->account, true);
        $this->accountHasCard($this->account, $this->card, true);
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
            'name'                          => 'nullable|string|max:255',
            'number'                        => 'nullable|numeric',
            'cvc'                           => 'nullable|numeric',
            'exp_month'                     => 'nullable|in:01,02,03,04,05,06,07,08,09,10,11,12',
            'exp_year'                      => 'nullable|numeric',
            'address_zip'                   => 'nullable|numeric',
            'country_id'                    => 'nullable|exists:countries,id',
        ];
    }
}
