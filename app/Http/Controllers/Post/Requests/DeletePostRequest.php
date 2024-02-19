<?php

namespace App\Http\Controllers\Post\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DeletePostRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('delete',$this->route('post'));
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
