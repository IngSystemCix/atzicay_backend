<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameProgressRequest extends FormRequest
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
            'GameSessionId' => [
                'required',
                'exists:GameSessions,id'
            ],
            'Progress' => [
                'required',
                'string'
            ]
        ];
    }

    public function messages(): array {
        return [
            'GameSessionId.required' => 'The game session ID is required.',
            'GameSessionId.exists' => 'The game session ID must exist in the GameSessions table.',
            'Progress.required' => 'The progress field is required.',
            'Progress.string' => 'The progress must be a string.',
        ];
    }
}
