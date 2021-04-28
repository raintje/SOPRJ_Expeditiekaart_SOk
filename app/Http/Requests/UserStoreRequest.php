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
            'name' => 'required|max:191',
            'email' => 'required|unique:users|email:rfc,dns,spoof|max:191',
        ];
    }

    /**
     * Returns the customized messages to be used in the front end.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'De naam van een gebruiker is verplicht.',
            'email.unique' => 'Er is al een account met dit e-mail adres',
            'email.required' => 'Het e-mail adres is verplicht.',

        ];
    }
}
