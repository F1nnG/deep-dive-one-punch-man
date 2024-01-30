<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Contracts\Validation\Validator;

class FormRequest extends \Illuminate\Foundation\Http\FormRequest
{
    /**
     * @throws Exception
     */
    protected function failedValidation(Validator $validator)
    {
        throw new Exception($validator->errors());
    }
}
