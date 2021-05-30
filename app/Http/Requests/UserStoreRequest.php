<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserStoreRequest extends FormRequest
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
            'name' => 'required|max:191',
            'email' => 'required|unique:users|email:rfc,dns,spoof|max:191',
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
            'name.required' => 'De naam van de gebruiker kan niet leeggelaten worden.',
            'name.max' => 'Een naam mag maximaal 191 karakters lang zijn',
            'email.required' => 'Het emailadres van de gebruiker kan niet leeggelaten worden.',
            'email.unique' => 'Er bestaat al een account met dit emailadres.',
            'email.email' => 'Voer alstublieft een geldig emailadres in.',
            'email.max' => 'Een emailadres mag maximaal 191 karakters lang zijn',
        ];
    }
}
