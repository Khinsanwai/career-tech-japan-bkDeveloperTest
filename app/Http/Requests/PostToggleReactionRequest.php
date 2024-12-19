<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class PostToggleReactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'post_id' => 'required|exists:posts,id',  
            'like'    => 'required|boolean',          
    }

    /**
     * Get the custom error messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'post_id.required' => 'Post ID is required.',
            'post_id.exists'   => 'The post you are trying to interact with does not exist.',
            'like.required'    => 'Like status is required.',
            'like.boolean'     => 'The like status must be either true or false.',
        ];
    }
}
