<?php

namespace App\Http\Requests\TeamInvites;


use App\Models\Account;
use App\Models\TeamInvite;
use App\Traits\HashesValues;
use App\Traits\ValidatesAccess;
use App\Traits\ValidatesResources;
use Illuminate\Foundation\Http\FormRequest;

class DeleteTeamInviteRequest extends FormRequest
{
    use HashesValues, ValidatesAccess, ValidatesResources;


    /**
     * @var Account
     */
    public $account;

    /**
     * @var TeamInvite
     */
    public $invitation;


    protected function prepareForValidation()
    {
        $this->route()->setParameter('id',  $this->decodeHash($this->route('id')));
    }

    public function authorize()
    {
        $this->invitation           = $this->findTeamInvite($this->route('id'));
        $this->account              = $this->invitation->account;
        $this->userOwnsTeamInvite(\Auth::user(), $this->invitation, true);

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
            if (!is_null($this->invitation->joined_at))
            {
                $validator->errors()->add('user', 'User has already joined account');
            }

        });
    }

}
