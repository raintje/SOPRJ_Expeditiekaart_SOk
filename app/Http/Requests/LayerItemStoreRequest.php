<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LayerItemStoreRequest extends FormRequest
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
            'title' => 'required|unique:layer_items|max:255',
            'body' => 'required|max:10000',
            'files.*' => 'mimes:jpg,jpeg,png,mp4,mpeg,pdf'
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
            'title.required' => 'De titel van een item is verplicht.',
            'title.unique' => 'De titel moet uniek zijn.',
            'body.required' => 'De inhoud van het item mag niet leeg zijn.',
            'files.*.mimes' => 'Bestanden moeten een van de volgende extensies hebben: .jpg, .jpeg, .png, .mp4, .mpeg, .pdf'
        ];
    }
}
