<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminAdRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['draft', 'active', 'archived'])],
            'condition' => ['required', Rule::in(['new', 'used'])],
            'category_id' => ['required', 'exists:categories,id'],
            'user_id' => ['required', 'exists:users,id'],
            'image' => ['nullable', 'image', 'max:2048'],
            'phone' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'naslov',
            'description' => 'opis',
            'price' => 'cena',
            'location' => 'lokacija',
            'status' => 'status',
            'condition' => 'stanje',
            'category_id' => 'kategorija',
            'user_id' => 'korisnik',
            'image' => 'slika oglasa',
            'phone' => 'telefon',
        ];
    }
}
