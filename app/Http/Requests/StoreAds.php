<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAds extends FormRequest
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
            'title'       => ['required','string'],
            'description' => ['required','string'],
            'category'    => ['required','string'],
            'sex'         => ['required','string'],
            'images'      => 'required',
            'images.*'    => 'mimes:jpeg,png,jpg|max:2048'
        ];
    }
}
