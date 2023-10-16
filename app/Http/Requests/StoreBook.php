<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBook extends FormRequest
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
            'titulo' => 'required|string|min:3|max:255',
            'indices' => 'array',
            'indices.*.titulo' => 'required|string|min:3|max:255',
            'indices.*.pagina' => 'required|integer',
            'indices.*.subindices' => 'array',
            'indices.*.subindices.*.titulo' => 'required|string|min:3|max:255',
            'indices.*.subindices.*.pagina' => 'required|integer',
            'indices.*.subindices.*.subindices' => 'array',
            'indices.*.subindices.*.subindices.*.titulo' => 'required|string|min:3|max:255',
            'indices.*.subindices.*.subindices.*.pagina' => 'required|integer',
            'indices.*.subindices.*.subindices.*.subindices' => 'array',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'O campo título é obrigatório.',
            'titulo.min'      => 'O título deve ter pelo menos :min caracteres.',
            'titulo.max'      => 'O título não pode ter mais de :max caracteres.',
        ];
    }
}
