<?php

namespace App\Http\Requests\Cards;


use App\Traits\HashesValues;
use App\Traits\ValidatesAccess;
use App\Traits\ValidatesResources;
use App\Models\Card;
use App\Models\Account;
use Illuminate\Foundation\Http\FormRequest;

class DeleteCardRequest extends FormRequest
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
            //
        ];
    }
}
