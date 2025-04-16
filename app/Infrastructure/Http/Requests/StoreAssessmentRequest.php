<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssessmentRequest extends FormRequest
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
            'GameInstanceId' => [
                'required',
                'exists:GameInstances,Id',
            ],
            'UserId' => [
                'required',
                'exists:Users,Id',
            ],
            'Value' => [
                'required',
                'integer',
            ],
            'Comments' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }

    /**
     * Summary of messages
     * @return array{Activated.boolean: string, Activated.required: string, Comments.max: string, Comments.required: string, Comments.string: string, GameInstanceId.exists: string, GameInstanceId.required: string, UserId.exists: string, UserId.required: string, Value.integer: string, Value.required: string}
     */
    public function messages(): array
    {
        return [
            'Activated.required' => 'The activated field is required.',
            'Activated.boolean' => 'The activated field must be true or false.',
            'GameInstanceId.required' => 'The game instance ID field is required.',
            'GameInstanceId.exists' => 'The game instance ID must exist in the GameInstances table.',
            'UserId.required' => 'The user ID field is required.',
            'UserId.exists' => 'The user ID must exist in the Users table.',
            'Value.required' => 'The value field is required.',
            'Value.integer' => 'The value must be an integer.',
            'Comments.required' => 'The comments field is required.',
            'Comments.string' => 'The comments must be a string.',
            'Comments.max' => 'The comments may not be greater than 255 characters.',
        ];
    }
}
