<?php

namespace App\Infrastructure\Http\Requests;

/**
 * @OA\Schema(
 *     schema="StoreUserFindRequest",
 *     type="object",
 *     required={"Email"},
 *     @OA\Property(
 *         property="Email",
 *         type="string",
 *         format="email",
 *         maxLength=255,
 *         example="user@example.com",
 *         description="The email of the user"
 *     )
 * )
 */
class StoreUserFindRequest extends FormRequest
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
            'Email' => [
                'required',
                'email',
                'max:255',
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array {
        return [
            'Email.required' => 'The email is required.',
            'Email.email' => 'The email must be a valid email address.',
            'Email.max' => 'The email may not be greater than 255 characters.',
        ];
    }
}
