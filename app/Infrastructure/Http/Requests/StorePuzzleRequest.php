<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePuzzleRequest extends FormRequest
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
            'GameInstanceId' => ['required', 'exists:GameInstances,Id'],
            'PathImg' => ['required', 'string'],
            'Clue' => ['required', 'string'],
            'Rows' => ['required', 'integer', 'min:1'],
            'Cols' => ['required', 'integer', 'min:1'],
            'automaticHelp' => ['required', 'boolean'],
        ];
    }

    public function messages(): array {
        return [
            'GameInstanceId.required' => 'The GameInstanceId field is required.',
            'GameInstanceId.exists' => 'The selected GameInstanceId is invalid.',
            'PathImg.required' => 'The PathImg field is required.',
            'PathImg.string' => 'The PathImg must be a string.',
            'Clue.required' => 'The Clue field is required.',
            'Clue.string' => 'The Clue must be a string.',
            'Rows.required' => 'The Rows field is required.',
            'Rows.integer' => 'The Rows must be an integer.',
            'Rows.min' => 'The Rows must be at least 1.',
            'Cols.required' => 'The Cols field is required.',
            'Cols.integer' => 'The Cols must be an integer.',
            'Cols.min' => 'The Cols must be at least 1.',
            'automaticHelp.required' => 'The automaticHelp field is required.',
            'automaticHelp.boolean' => 'The automaticHelp must be true or false.',
        ];
    }
}
