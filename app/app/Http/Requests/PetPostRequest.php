<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'user_id' => 'required|exists:users,id',
            'coordinate_x' => 'required|integer',
            'coordinate_y' => 'required|integer',
            'breed' => 'required|string',
            'type' => 'required|string',
            'additional_info' => 'sometimes|string',
            'photos[]' => 'sometimes|file|extensions:jpg,png'
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
}
