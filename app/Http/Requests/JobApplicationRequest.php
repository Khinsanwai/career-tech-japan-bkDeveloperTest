<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobApplicationRequest extends FormRequest
{
    public function authorize()
    {
        // If authorization is needed, define your logic here.
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'job_position' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.unique' => 'This email is already used.',
            'resume.required' => 'Resume is required.',
            'resume.mimes' => 'Only PDF, DOC, and DOCX files are allowed.',
            'resume.max' => 'Resume size should not exceed 10MB.',
            'job_position.required' => 'Job position is required.',
        ];
    }
}
