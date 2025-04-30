<?php

namespace App\Infrastructure\Http\Requests;

/**
 * @OA\Schema(
 *     schema="StoreWordsRequest",
 *     type="object",
 *     required={"SolveTheWordId", "Word", "Orientation"},
 *     @OA\Property(
 *         property="SolveTheWordId",
 *         type="integer",
 *         example=1,
 *         description="The ID of the SolveTheWord record"
 *     ),
 *     @OA\Property(
 *         property="Word",
 *         type="string",
 *         maxLength=45,
 *         example="exampleword",
 *         description="The word to be solved"
 *     ),
 *     @OA\Property(
 *         property="Orientation",
 *         type="string",
 *         enum={"HL", "HR", "VU", "VD", "DU", "DD"},
 *         example="HL",
 *         description="The orientation of the word (HL=Horizontal Left, HR=Horizontal Right, VU=Vertical Up, VD=Vertical Down, DU=Diagonal Up, DD=Diagonal Down)"
 *     )
 * )
 */
class StoreWordsRequest extends FormRequest
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
            'SolveTheWordId' => [
                'required',
                'exists:SolveTheWord,GameInstanceId',
            ],
            'Word' => [
                'required',
                'string',
                'max:45',
            ],
            'Orientation' => [
                'required',
                'in:HL,HR,VU,VD,DU,DD'
            ]
        ];
    }

    /**
     * Summary of messages
     * @return array{Orientation.in: string, Orientation.required: string, SolveTheWordId.exists: string, SolveTheWordId.required: string, Word.max: string, Word.required: string, Word.string: string}
     */
    public function messages(): array {
        return [
            'SolveTheWordId.required' => 'The SolveTheWordId field is required.',
            'SolveTheWordId.exists' => 'The selected SolveTheWordId is invalid.',
            'Word.required' => 'The Word field is required.',
            'Word.string' => 'The Word must be a string.',
            'Word.max' => 'The Word may not be greater than 45 characters.',
            'Orientation.required' => 'The Orientation field is required.',
            'Orientation.in' => 'The Orientation must be one of the following values: HL, HR, VU, VD, DU, DD.',
        ];
    }
}
