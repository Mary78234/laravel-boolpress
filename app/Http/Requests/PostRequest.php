<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required|max:10',
            'content' => 'required|min:3'
        ];
    }

    public function messages(){
        return [
            'title.required' => 'Ti sei dimenticato di inserire il titolo!',
            'title.max' => 'Hai superato in massimo di :max di caratteri consentito.',
            'content.required' => 'Ti sei dimenticato di inserire il contenuto!',
            'content.min' => 'Hai scritto troppo poco! Devi superare :min caratteri.'
        ];
    }
}
