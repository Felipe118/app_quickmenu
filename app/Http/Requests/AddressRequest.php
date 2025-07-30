<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'address_name' => 'required|string|max:255',
            'quatrain' => 'required|string|max:255',
            'city'=> 'required|string|max:255',
            'state'=> 'required|string|max:255',
            'cep'=> 'required|string|max:20',
            'complement'=> 'nullable|string|max:255',
            'district'=> 'required|string|max:255',
            'number'=> 'required|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'address_name.required'=> 'O campo nome é obrigatório',
            'address_name.string'=> 'O campo nome deve ser uma string',
            'address_name.max'=> 'O campo nome deve ter no máximo 255 caracteres',
            'quatrain.required'=> 'O campo quadra é obrigatório',
            'quatrain.string'=> 'O campo quadra deve ser uma string',
            'quatrain.max'=>  'O campo quadra deve ter no máximo 255 caracteres',
            'city.required'=> 'O campo cidade é obrigatório',
            'city.string'=> 'O campo cidade deve ser uma string',
            'city.max'=> 'O campo cidade deve ter no máximo 255 caracteres',
            'state.required'=> 'O campo estado é obrigatório',
            'state.string'=> 'O campo estado deve ser uma string',
            'state.max'=> 'O campo estado deve ter no máximo 255 caracteres',
            'cep.required'=> 'O campo cep é obrigatório',
            'cep.string'=> 'O campo cep deve ser uma string',
            'cep.max'=> 'O campo cep deve ter no máximo 20 caracteres',
            'complement.string'=> 'O campo complemento deve ser uma string',
            'complement.max'=> 'O campo complemento deve ter no máximo 255 caracteres',
            'district.required'=> 'O campo bairro é obrigatório',
            'district.string'=> 'O campo bairro deve ser uma string',
            'district.max'=> 'O campo bairro deve ter no máximo 255 caracteres',
            'number.required'=> 'O campo número é obrigatório',
            'number.string'=> 'O campo número deve ser uma string',
            'number.max'=> 'O campo número deve ter no máximo 20 caracteres',
            
        ];
    }
}
