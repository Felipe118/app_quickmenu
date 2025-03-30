<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'profile_id'=> 'nullable|integer|exists:profile,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo name é obrigatório',
            'name.string' => 'O campo name deve ser uma string',
            'name.max' => 'O campo name deve ter no máximo 255 caracteres',
            'email.required' => 'O campo email é obrigatório',
            'email.string' => 'O campo email deve ser uma string',
            'email.email' => 'O campo email deve ser um email',
            'email.max' => 'O campo email deve ter no máximo 255 caracteres',
            'email.unique' => 'Esse email já está cadastrado no sistema',
            'password.required' => 'O campo senha é obrigatório',
            'password.string' => 'O campo senha deve ser uma string',
            'password.min' => 'O campo senha deve ter no mínimo 8 caracteres',
            'profile_id.integer' => 'O campo profile_id deve ser um inteiro',
            'profile_id.exists' => 'O perfil informado não existe',
        ];
    }
}
