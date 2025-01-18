<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VenteFormRequest extends FormRequest
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
            // 'produit' => ['required', 'exists:produits,id'],
            'nom' => ['required', 'string', 'min:3'],
            'nombre' => ['required', 'integer', 'min:1'],
            'prix' => ['required', 'integer', 'min:3'],
            'user_id' => ['exists:users,id', 'required'],
            // 'types' => ['array', 'exists:types,id', 'required'],
            // 'etat' => ['required', 'boolean'],
        ];
    }
}
