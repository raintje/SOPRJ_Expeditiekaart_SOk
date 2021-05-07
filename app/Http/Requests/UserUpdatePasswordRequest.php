<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserUpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check()){
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
            'user' => 'exists:users,id',
            'password' => 'required|string|min:8|confirmed',
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

        ];
    }
}
