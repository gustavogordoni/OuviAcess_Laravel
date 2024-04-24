<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequerimentoRequest extends FormRequest
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
            'titulo' => [
                'required',
                'string',
                'max:150',
                'min:10',
                'regex:/^[\pL\s]+$/u',
            ],
            'tipo' => [
                'required',
                'string',
                'in:Denúncia,Sugestão',
            ],
            'cidade' => [
                'required',
                'string',
                'min:3',
                'regex:/^[A-Za-zÀ-ÿ\s]+$/u',
                'max:150',
            ],
            'cep' => [
                'required',
                'string',
                'regex:/^\d{2}\.\d{3}-\d{3}$/',
            ],
            'bairro' => [
                'required',
                'string',
                'regex:/^[A-Za-zÀ-ÿ0-9\s]+$/u',
                'max:150',
            ],
            'logradouro' => [
                'required',
                'string',
                'regex:/^[A-Za-zÀ-ÿ0-9\s]+$/u',
                'max:150',
            ],
            'descricao' => [
                'required',
                'string',
                'min:50',
                'max:2000',
            ],
            'image' => [
                'nullable',
                'image',
                'max:2048', // Limita o tamanho máximo da imagem a 2MB
            ],
        ];
    }
}
