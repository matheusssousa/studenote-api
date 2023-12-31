<?php

namespace App\Http\Requests;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoriaRequest extends FormRequest
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
                // Função para um usuário não ter duas categorias com o mesmo nome, mas outro usuário poder ter uma categoria com o mesmo nome.
                Rule::unique('categorias')->where(fn (Builder $query) => $query->where('user_id', auth()->user()->id))
            ],
            'cor' => 'required'
        ];
    }
}
