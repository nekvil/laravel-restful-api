<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

/**
 * @OA\Schema(
 *     schema="StoreNotebookRequest",
 *     required={"full_name", "phone", "email"},
 *     @OA\Property(property="full_name", type="string", example="Ivan Ivanov"),
 *     @OA\Property(property="company", type="string", example="Company ABC"),
 *     @OA\Property(property="phone", type="string", example="+79151234567"),
 *     @OA\Property(property="email", type="string", example="ivan.ivanov@test.com"),
 *     @OA\Property(property="birth_date", type="string", format="date", example="01.01.1999"),
 *     @OA\Property(property="photo", type="string", example="path/to/photo.jpg")
 * )
 */
class StoreNotebookRequest extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'birth_date' => 'nullable|date',
            'photo' => 'nullable|string|max:255'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
