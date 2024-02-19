<?php

namespace App\Http\Controllers\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCommentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'text'    => 'required|string|min:3',
            'post_id' => 'required|exists:posts,id'
            //'reply_id'=>'nullable|exists:comment:id'
        ];
    }
}
