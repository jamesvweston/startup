<?php

namespace App\Http\Requests\Users;


use App\Traits\HashesValues;
use App\Traits\ValidatesAccess;
use App\Traits\ValidatesResources;
use App\Models\ConfirmationToken;
use Illuminate\Foundation\Http\FormRequest;

class ConfirmEmailTokenRequest extends FormRequest
{

    use HashesValues, ValidatesAccess, ValidatesResources;

    /**
     * @var ConfirmationToken
     */
    public $confirmation_token;


    protected function prepareForValidation()
    {
        $this->route()->setParameter('confirmation_token',  $this->decodeHash($this->route('confirmation_token')));
    }

    public function authorize()
    {
        $this->confirmation_token           = $this->findConfirmationToken($this->route('confirmation_token'));
        $this->authHasUser($this->confirmation_token->user, true);

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
            if ($this->confirmation_token->hasExpired())
            {
                $validator->errors()->add('token', 'Your email confirmation token has expired');
            }
        });
    }
}
