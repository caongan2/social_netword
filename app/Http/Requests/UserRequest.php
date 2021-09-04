<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'between: 2,50 | regex: /^[A-Z a-z]+$/',
            'phone' => 'regex: /^0[1-9][0-9]{8}$/',
            'address' => 'between: 2,50',
            'interest' => 'between: 2,50',
        ];
    }

    public function messages()
    {
        $messages = [
            'name.between' => 'Field name must between 2 and 50 characters',
            'phone.regex' => 'It is not a phone format',
            'address.between' => 'Field address must between 2 and 50 characters',
            'interest' => 'Field interest must between 2 and 50 characters'
        ];
        return $messages;
    }
}
