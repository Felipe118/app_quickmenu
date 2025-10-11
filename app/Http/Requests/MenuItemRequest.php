<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemRequest extends FormRequest
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
            "description" => "string|min:3",
            "price"=> "required|numeric|min:0.01",
            "img"=> "image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            "menu_id" => "required|exists:menu,id",
            "category_id" => "required|exists:categories,id"
        ];
    }

    public function messages(): array
    {
        return [
            "name.required"=> "O campo name é obrigatório",
            "name.string"=>  "O campo name deve ser uma string",
            "description.string"=> "O campo description deve ser uma string",
            "description.min"=> "O campo description deve ter no mínimo 3 caracteres",
            "price.required"=> "O campo price é obrigatório",
            "price.numeric"=> "O campo price deve ser um valor numérico",
            "price.min"=> "O campo price deve ter no mínimo 0.01",
            "img.image"=> "O campo img deve ser uma imagem",
            "img.mimes"=> "O campo img deve ser uma imagem",
            "img.max"=> "O campo img deve ter no máximo 2048kb",
            "menu_id.required"=> "O campo menu é obrigatório",
            "menu_id.exists"=> "O menu informado nao existe",
            "category_id.required"=> "O campo category é obrigatório",
            "category_id.exists"=> "A categoria informada nao existe"
        ];
    }
}
