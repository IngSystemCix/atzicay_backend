<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWordsRequest extends FormRequest
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
            'SolveTheWordId' => [
                'required',
                'exists:SolveTheWord,Id',
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
