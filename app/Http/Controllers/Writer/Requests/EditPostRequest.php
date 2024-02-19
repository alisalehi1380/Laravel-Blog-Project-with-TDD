<?php

namespace App\Http\Controllers\Writer\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class EditPostRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('view', $this->route('post'));
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
