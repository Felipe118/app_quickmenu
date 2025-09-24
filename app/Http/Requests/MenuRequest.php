<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            'restaurant_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'image' => 'string',
        ];
    }
    public function messages(): array
    {
        return [
            'restaurant_id.required' => 'O campo restaurante é obrigatório',
            'restaurant_id.integer' => 'O campo restaurante deve ser um inteiro',
            'name.required' => 'O campo name é obrigatório',
            'name.string' => 'O campo name deve ser uma string',
            'name.max' => 'O campo name deve ter no.maxcdn 255 caracteres',
            'image.string'=> 'O campo image deve ser uma string',
        ];
    }
}
