<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class CreatePersonRequest extends FormRequest
{
    /**
     * Determine if the articles is authorized to make this request.
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
            'personName' => 'required|max:255',
            'faction' => 'required|integer',
            'notes' => 'nullable',
            'picture' => 'nullable'
        ];
    }
}
