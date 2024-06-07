<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PetPostRequest extends FormRequest
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
            "name" => "required|string",
            'user_id' => 'required|exists:users,id',
            'coordinate_x' => 'required|integer',
            'coordinate_y' => 'required|integer',
            'breed' => 'required|string',
            'type' => 'required|string',
            'additional_info' => 'sometimes|string',
            'pet_images[]' => 'image|mimes:jpg,png'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'exists' => 'Usuário inexistente.',
            'integer' => 'O campo :attribute precisa ser um inteiro valido.',
            'string' => 'O campo :attribute precisa ser um texto válido.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'errors' => $validator->errors(),
            'message' => 'Falha para criar o produto'
        ], 422);

        throw new HttpResponseException($response);
    }
}
