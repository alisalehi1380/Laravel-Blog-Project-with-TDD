<?php

namespace App\Http\Controllers\Writer\Requests;

use App\Rules\CheckPostSlugUniqueRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateWriterPostRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('update', $this->route('post'));
    }

    public function rules()
    {
        return [
            "title"      => 'required|string|min:6',
            "slug"       => ['required', 'string', 'min:6', new CheckPostSlugUniqueRule($this->route('post'))],
            "cover"      => 'required|string|min:2',
            "body"       => 'required',
            "categories" => 'required',
            "tags"       => 'required',
        ];
    }
}
