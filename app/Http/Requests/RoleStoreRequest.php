<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RoleStoreRequest extends FormRequest
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
            'name' => 'required|unique:roles|max:191',
            'items' => 'required|array',
            'items.*' => 'exists:layer_items,id',
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
            'name.required' => 'De naam van de rol kan niet leeggelaten worden.',
            'name.max' => 'Een naam mag maximaal 191 karakters lang zijn',
            'items.required' => 'Er moet minimaal 1 item geselecteerd worden',
        ];
    }
}
