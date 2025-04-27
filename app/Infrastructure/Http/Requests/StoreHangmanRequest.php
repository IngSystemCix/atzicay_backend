<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreHangmanRequest",
 *     type="object",
 *     required={"GameInstanceId", "Word", "Presentation"},
 *     @OA\Property(
 *         property="GameInstanceId",
 *         type="integer",
 *         example="1",
 *         description="The ID of the game instance"
 *     ),
 *     @OA\Property(
 *         property="Word",
 *         type="string",
 *         example="example",
 *         description="The word to be guessed in the Hangman game"
 *     ),
 *     @OA\Property(
 *         property="Clue",
 *         type="string",
 *         example="A word related to technology",
 *         description="An optional clue for the word"
 *     ),
 *     @OA\Property(
 *         property="Presentation",
 *         type="string",
 *         enum={"A", "F"},
 *         example="A",
 *         description="The format of the Hangman presentation. 'A' for active, 'F' for finished"
 *     )
 * )
 */
class StoreHangmanRequest extends FormRequest
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
            'GameInstanceId' => [
                'required', 
                'exists:GameInstances,Id'
            ],
            'Word' => [
                'required', 
                'string', 
                'max:60'
            ],
            'Clue' => [
                'nullable', 
                'string', 
                'max:100'
            ],
            'Presentation' => [
                'required', 
                'in:A,F'
            ],
        ];
    }
    
    public function messages(): array
    {
        return [
            'GameInstanceId.required' => 'The GameInstanceId field is required.',
            'GameInstanceId.exists' => 'The selected GameInstanceId is invalid.',
            'Word.required' => 'The Word field is required.',
            'Word.string' => 'The Word must be a string.',
            'Word.max' => 'The Word may not be greater than 60 characters.',
            'Clue.string' => 'The Clue must be a string.',
            'Clue.max' => 'The Clue may not be greater than 100 characters.',
            'Presentation.required' => 'The Presentation field is required.',
            'Presentation.in' => 'The Presentation must be either A or F.',
        ];
    }
}
