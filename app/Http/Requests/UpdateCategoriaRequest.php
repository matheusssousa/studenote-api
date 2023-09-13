<?php

namespace App\Http\Requests;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoriaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nome' => [
                'required',
                'min:3',
                // Função especifica para um usuário não ter duas notas com o mesmo nome, mas outro usuário poder ter uma nota com o mesmo nome
                Rule::unique('categorias')->where(function ($query) {
                    return $query->where('user_id', auth()->user()->id);
                    // O ignone vai ignorar o registro da categoria atual ao verificar a tabela de nomes, além disso, $this->route('categorum') vai peggar o ID lá do link da rota
                })->ignore($this->route('categorium'))
            ],
            'cor' => 'required'
        ];
    }
}
