<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
            "email"=> "required|string|email|max:255|unique:users",
            "password"=> "required|string|min:8|confirmed",
            "password_confirmation"=> "required|string|min:8",
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'O campo email é obrigatório',
            'email.string' => 'O campo email deve ser uma string',
            'email.email' => 'O campo email deve ser um email',
            'email.max' => 'O campo email deve ter no máximo 255 caracteres',
            'email.unique' => 'Esse email já está cadastrado no sistema',
            'password.required' => 'O campo senha é obrigatório',
            'password.string' => 'O campo senha deve ser uma string',
            'password.min' => 'O campo senha deve ter no mínimo 8 caracteres',
            'password_confirmation.required' => 'O campo confirmação de senha é obrigatório',
            'password_confirmation.string' => 'O campo confirmação de senha deve ser uma string',
            'password_confirmation.min' => 'O campo confirmação de senha deve ter no mínimo 8 caracteres',
        ];
    }
}
