<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgrammingGameRequest extends FormRequest
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
            'GameInstancesId' => ['required', 'integer', 'exists:GameInstances,Id'],
            'ProgrammerId' => ['required', 'integer', 'exists:Users,Id'],
            'name' => ['required', 'string', 'max:50'],
            'StartTime' => ['required', 'date'],
            'EndTime' => ['required', 'date', 'after:StartTime'],
            'Attempts' => ['required', 'integer', 'min:1'],
            'MaximumTime' => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array {
        return [
            'GameInstancesId.required' => 'The game instance ID is required.',
            'GameInstancesId.integer' => 'The game instance ID must be an integer.',
            'GameInstancesId.exists' => 'The selected game instance ID is invalid.',
            'ProgrammerId.required' => 'The programmer ID is required.',
            'ProgrammerId.integer' => 'The programmer ID must be an integer.',
            'ProgrammerId.exists' => 'The selected programmer ID is invalid.',
            'name.required' => 'The name is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 50 characters.',
            'StartTime.required' => 'The start time is required.',
            'StartTime.date' => 'The start time must be a valid date.',
            'EndTime.required' => 'The end time is required.',
            'EndTime.date' => 'The end time must be a valid date.',
            'EndTime.after' => 'The end time must be after the start time.',
            'Attempts.required' => 'The number of attempts is required.',
            'Attempts.integer' => 'The number of attempts must be an integer.',
            'Attempts.min' => 'The number of attempts must be at least 1.',
            'MaximumTime.required' => 'The maximum time is required.',
            'MaximumTime.integer' => 'The maximum time must be an integer.',
            'MaximumTime.min' => 'The maximum time must be at least 1.',
        ];
    }
}
