<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotasRequest extends FormRequest
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
            'nome' => 'required|min:3',
            'descricao' => 'required|max:10000',
            'disciplina_id' => 'exists:disciplinas,id',
            'annotation_community' => 'boolean',
            'categorias' => 'exists:categorias,id',
            // Validar o arquivo dentro do array arquivo
            'arquivo.*' => 'file|mimes:png,docx,pdf,jpeg,jpg|max:3144'
        ];
    }
}
