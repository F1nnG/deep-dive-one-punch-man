<?php

namespace App\Http\Requests\BattleRequest;

use App\Http\Requests\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
        ];
    }
}
