<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetSalaryRequest extends FormRequest
{
    public function authorize()
    {
        // Ensure the user is authenticated
        return auth()->check();
    }

    public function rules()
    {
        return [
            'staff_id' => 'required|integer|exists:users,id',  // Validate that staff_id exists in the users table
        ];
    }
}
