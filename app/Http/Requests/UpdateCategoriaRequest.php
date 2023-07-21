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
                // FUNÇÃO ESPECIFICA PARA UM USUÁRIO NÃO PODER TER DUAS NOTAS COM O MESMO NOME, MAS OUTRO USUÁRIO PODER TER UMA NOTA COM O MESMO NOME
                Rule::unique('categorias')->where(fn (Builder $query) => $query->where('user_id', auth()->user()->id))
            ],
            'cor' => 'required'
        ];
    }
}
