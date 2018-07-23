<?php

namespace App\Http\Requests\Roles;


use App\Traits\HashesValues;
use App\Traits\PaginatesResults;
use Illuminate\Foundation\Http\FormRequest;

class GetRolesRequest extends FormRequest
{

    use HashesValues, PaginatesResults;

    protected function prepareForValidation()
    {
        $this->merge(['ids' => $this->decodeHash($this->input('ids'))]);
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
