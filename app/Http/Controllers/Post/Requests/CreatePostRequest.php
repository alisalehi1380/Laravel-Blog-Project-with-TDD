<?php

namespace App\Http\Controllers\Post\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "title"      => 'required|string|min:6',
            "slug"       => 'required|string|min:6|unique:posts,slug',
            "cover"      => 'required|string|min:2',
            "body"       => 'required',
            "categories" => 'required',
            "tags"       => 'required',
        ];
    }
}
