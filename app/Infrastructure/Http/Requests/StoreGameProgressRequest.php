<?php

namespace App\Infrastructure\Http\Requests;

/**
 * @OA\Schema(
 *     schema="StoreGameProgressRequest",
 *     type="object",
 *     required={"GameSessionId", "Progress"},
 *     @OA\Property(
 *         property="GameSessionId",
 *         type="integer",
 *         example=1,
 *         description="The ID of the game session"
 *     ),
 *     @OA\Property(
 *         property="Progress",
 *         type="string",
 *         example="Level 1 completed",
 *         description="The current progress in the game session"
 *     )
 * )
 */
class StoreGameProgressRequest extends FormRequest
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
