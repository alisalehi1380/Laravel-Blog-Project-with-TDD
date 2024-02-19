<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|min:3|unique:categories,title'
        ];
    }
}
