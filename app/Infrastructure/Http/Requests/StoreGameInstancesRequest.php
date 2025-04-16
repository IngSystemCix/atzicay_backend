<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameInstancesRequest extends FormRequest
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
            'Name' => ['required','string','max:40'],
            'Description' => ['required','string','max:300'],
            'ProfessorId' => ['required','integer','exists:Users,Id'],
            'Activated' => ['required','boolean'],
            'Difficulty' => ['required','string','in:E,M,H'],
            'Visibility' => ['required','string','in:P,R'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array {
        return [
            'Name.required' => 'The name field is required.',
            'Name.string' => 'The name must be a string.',
            'Name.max' => 'The name may not be greater than 40 characters.',
            'Description.required' => 'The description field is required.',
            'Description.string' => 'The description must be a string.',
            'Description.max' => 'The description may not be greater than 300 characters.',
            'ProfessorId.required' => 'The professor ID field is required.',
            'ProfessorId.integer' => 'The professor ID must be an integer.',
            'ProfessorId.exists' => 'The professor ID must exist in the Users table.',
            'Activated.required' => 'The activated field is required.',
            'Activated.boolean' => 'The activated field must be true or false.',
            'Difficulty.required' => 'The difficulty field is required.',
            'Difficulty.string' => 'The difficulty must be a string.',
            'Difficulty.in' => 'The difficulty must be one of the following values: E, M, H.',
            'Visibility.required' => 'The visibility field is required.',
            'Visibility.string' => 'The visibility must be a string.',
            'Visibility.in' => 'The visibility must be one of the following values: P, R.',
        ];
    }
}
