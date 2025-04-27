<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreGameSessionRequest",
 *     type="object",
 *     required={"ProgrammingGameId", "StudentId", "Duration", "Won", "DateGame"},
 *     @OA\Property(
 *         property="ProgrammingGameId",
 *         type="integer",
 *         example=1,
 *         description="The ID of the programming game"
 *     ),
 *     @OA\Property(
 *         property="StudentId",
 *         type="integer",
 *         example=1,
 *         description="The ID of the student"
 *     ),
 *     @OA\Property(
 *         property="Duration",
 *         type="integer",
 *         example=30,
 *         description="The duration of the game session in minutes"
 *     ),
 *     @OA\Property(
 *         property="Won",
 *         type="boolean",
 *         example=true,
 *         description="Indicates if the student won the game"
 *     ),
 *     @OA\Property(
 *         property="DateGame",
 *         type="string",
 *         format="date",
 *         example="2025-04-26",
 *         description="The date of the game session"
 *     )
 * )
 */
class StoreGameSessionRequest extends FormRequest
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
            'ProgrammingGameId' => [
                'required',
                'integer',
                'exists:ProgrammingGame,Id',
            ],
            'StudentId' => [
                'required',
                'integer',
                'exists:Users,Id',
            ],
            'Duration' => [
                'required',
                'integer',
            ],
            'Won' => [
                'required',
                'boolean',
            ],
            'DateGame' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
        ];
    }

    public function messages(): array {
        return [
            'ProgrammingGameId.required' => 'The programming game ID is required.',
            'ProgrammingGameId.integer' => 'The programming game ID must be an integer.',
            'ProgrammingGameId.exists' => 'The selected programming game ID is invalid.',
            'StudentId.required' => 'The student ID is required.',
            'StudentId.integer' => 'The student ID must be an integer.',
            'StudentId.exists' => 'The selected student ID is invalid.',
            'Duration.required' => 'The duration is required.',
            'Duration.integer' => 'The duration must be an integer.',
            'Won.required' => 'The Won field is required.',
            'Won.boolean' => 'The Won field must be true or false.',
            'DateGame.required' => 'The date of the game is required.',
            'DateGame.date' => 'The date of the game must be a valid date.',
            'DateGame.before_or_equal' => 'The date of the game must be today or earlier.',
        ];
    }
}
