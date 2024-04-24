<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'ddd' => [
                'required',
                'min:4',
                'max:4',
                'regex:/^\([0-9]{2}\)$/',
            ],
            'phone' => [
                'required',
                'min:10',
                'max:10',
                'regex:/[0-9]{4,6}-[0-9]{3,4}/'
            ],
        ];
    }
}
