<?php

namespace App\Http\Requests\TeamInvites;


use App\Models\Account;
use App\Traits\HashesValues;
use App\Traits\ValidatesAccess;
use App\Traits\ValidatesResources;
use Illuminate\Foundation\Http\FormRequest;

class CreateTeamInviteRequest extends FormRequest
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
            'email'             => 'required|string|email|max:255',
            'role'              => 'required|string|max:255',
            'account_id'        => 'required|integer',
        ];
    }

    /**
     * @param  \Illuminate\Validation\Validator $validator
     */
    public function withValidator ($validator)
    {
        $validator->after(function () use ($validator)
        {
            $this->account              = $this->findAccount($this->input('account_id'));
            $this->userHasAccount(\Auth::user(), $this->account, true);
            if ($this->account->invitations()->newQuery()->where('email', '=', $this->input('email'))->first())
            {
                $validator->errors()->add('email', 'Has already been invited to this account');
            }

            if ($this->account->members()->where('email', '=', $this->input('email'))->first())
            {
                $validator->errors()->add('email', 'User is already a member of this account');
            }
        });
    }

}
