<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|unique:posts|max:255',
            'type' => 'required',
            'path' => 'required',
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
            'title.required' => 'De titel kan niet leeg worden gelaten.',
            'type.required' => 'Het type van het bestand kan niet leeg worden gelaten.',
            'path.required' => 'De locatie van het bestand is vereist.'
        ];
    }
}
