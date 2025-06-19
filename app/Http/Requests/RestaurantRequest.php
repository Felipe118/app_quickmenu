<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantRequest extends FormRequest
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
            "name"=> "required|string|max:255",
            "perfil_img"=> "string|max:255",
            "capa_img"=> "string|max:255",
            "email"=>  "required|string|email|max:255",
            "open_time"=> "required|max:255",
            "close_time"=> "required|max:255",
            "phone"=> "required|phone|max:30",
            "active"=> "required|boolean",
            "address_id"=> "required|integer|exists:address,id",
        ];
    }

    public function messages(): array
    {
        return [
            "name.required"=> "O campo name é obrigatório",
            "name.string"=> "O campo name deve ser uma string",
            "name.max"=> "O campo name deve ter no máximo 255 caracteres",
            "email.required"=>  "O campo email é obrigatório",
            "email.string"=> "O campo email deve ser uma string",
            "email.email"=> "O campo email deve ser um email",
            "email.max"=> "O campo email deve ter no máximo 255 caracteres",
            "open_time.required"=> "O campo Hora de Abertura é obrigatório",
            "close_time.required"=> "O campo Hora de Fechamento é obrigatório",
            "phone.required"=> "O campo telefone é obrigatório",
            "phone.phone"=> "O campo telefone deve ser um telefone",
            "phone.max"=> "O campo telefone deve ter no máximo 30 caracteres",
            "address_id.required"=> "O campo endereço é obrigatório",
        ];
    }
}
