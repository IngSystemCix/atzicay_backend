<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Activated' => [
                'required',
                'boolean',
            ],
            'GoogleId' => [
                'required',
                'string',
                'max:255',
                'unique:Users,GoogleId'
            ],
            'Email' => [
                'required',
                'email',
                'max:255',
            ],
            'Name' => [
                'required',
                'string',
                'max:35',
            ],
            'LastName' => [
                'required',
                'string',
                'max:35',
            ],
            'Gender' => [
                'required',
                'string',
                'in:M,F,O',
            ],
            'Country' => [
                'required',
                'exists:Country,Id',
            ],
            'City' => [
                'required',
                'string',
                'max:40',
            ],
            'Birthdate' => [
                'required',
                'date',
            ],
            'CreatedAt' => [
                'required',
                'date',
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array {
        return [
            'Activated.required' => 'The activated field is required.',
            'Activated.boolean' => 'The activated field must be true or false.',
            'GoogleId.required' => 'The Google ID is required.',
            'GoogleId.string' => 'The Google ID must be a string.',
            'GoogleId.max' => 'The Google ID may not be greater than 255 characters.',
            'GoogleId.unique' => 'The Google ID has already been taken.',
            'Email.required' => 'The email is required.',
            'Email.email' => 'The email must be a valid email address.',
            'Email.max' => 'The email may not be greater than 255 characters.',
            'Name.required' => 'The name is required.',
            'Name.string' => 'The name must be a string.',
            'Name.max' => 'The name may not be greater than 35 characters.',
            'LastName.required' => 'The last name is required.',
            'LastName.string' => 'The last name must be a string.',
            'LastName.max' => 'The last name may not be grater than 35 characters',
            'Gender.required' => 'The gender is required.',
            'Gender.string' => 'The gender must be a string.',
            'Gender.in' => 'The gender must be one of the following values: M, F, O.',
            'Country.required' => 'The country is required.',
            'Country.exists' => 'The selected country is invalid.',
            'City.required' => 'The city is required.',
            'City.string' => 'The city must be a string.',
            'City.max' => 'The city may not be greater than 40 characters.',
            'Birthdate.required' => 'The birthdate is required.',
            'Birthdate.date' => 'The birthdate must be a valid date.',
            'CreatedAt.required' => 'The created at date is required.',
            'CreatedAt.date' => 'The created at date must be a valid date.',
        ];
    }
}
