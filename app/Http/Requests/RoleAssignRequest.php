<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RoleAssignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check() && Auth::user()->hasRole('super admin')){
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role' => 'required|integer|exists:roles,id|max:191',
        ];
    }

    /**
     * Returns the custom error messages to be used in the validation of user creation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'role.required' => 'Een rol selecteren is verplicht',
            'role.integer' => 'De rol moet geselecteerd worden in de dropdown',
            'role.exists' => 'De rol moet geselecteerd worden in de dropdown',
        ];
    }
}
