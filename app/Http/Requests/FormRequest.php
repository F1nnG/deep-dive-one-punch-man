<?php

namespace App\Http\Requests;

use Exception;

class FormRequest extends \Illuminate\Foundation\Http\FormRequest
{
    /**
     * @throws Exception
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new Exception($validator->errors());
    }
}
