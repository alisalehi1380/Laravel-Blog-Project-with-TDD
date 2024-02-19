<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWriterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'                  => 'required|min:4|string',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:4|confirmed',

        ];
    }
}
