<?php

namespace App\Http\Requests\Users;


use App\Traits\HashesValues;
use App\Traits\ValidatesAccess;
use App\Traits\ValidatesResources;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdatePasswordRequest extends FormRequest
{

    use HashesValues, ValidatesAccess, ValidatesResources;

    /**
     * @var User
     */
    public $user;


    protected function prepareForValidation()
    {
        $this->route()->setParameter('id',  $this->decodeHash($this->route('id')));
    }

    public function authorize()
    {
        $this->user             = $this->findUser($this->route('id'));
        $this->authHasUser($this->user, true);

        return \Auth::user()->id = $this->user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password'          => 'required|string|min:6',
            'new_password'      => 'required|string|min:6|confirmed',
        ];
    }

    /**
     * @param  \Illuminate\Validation\Validator $validator
     */
    public function withValidator ($validator)
    {
        $validator->after(function () use ($validator)
        {
            if (!$this->user->passwordEquals($this->input('password')))
            {
                $error                          = ValidationException::withMessages([
                    'password'                  => [
                        'Does not match'
                    ]
                ]);
                throw $error;
            }
        });
    }

}
