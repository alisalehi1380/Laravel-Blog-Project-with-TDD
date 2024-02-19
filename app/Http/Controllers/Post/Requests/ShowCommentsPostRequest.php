<?php

namespace App\Http\Controllers\Post\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ShowCommentsPostRequest extends FormRequest
{
    public function authorize()
    {
        return (bool) Gate::authorize('view' , $this->route('post'));
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
