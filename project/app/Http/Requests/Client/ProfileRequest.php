<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        $userId = current_user()->id;
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|string|min:6|max:12',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $rules['email'] .= ",{$userId}";
            $rules['password'] = data_get($this, 'password', '') ? $rules['password'] : '';
        }

        return $rules;
    }
}
