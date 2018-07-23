<?php

namespace App\Http\Requests\Users;


use App\Traits\HashesValues;
use App\Traits\ValidatesAccess;
use App\Traits\ValidatesResources;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $this->authHasUser($this->user);

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
            'first_name'        => 'nullable|string|max:255',
            'last_name'         => 'nullable|string|max:255',
            'email'             => 'nullable|string|email|max:255|unique:users,email,' . $this->route('id'),
        ];
    }
}
