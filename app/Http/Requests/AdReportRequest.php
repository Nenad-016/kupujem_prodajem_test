<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdReportRequest extends FormRequest
{
    /**
     * Korisnik ima pravo da šalje prijavu.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validacija za prijavu oglasa.
     */
    public function rules(): array
    {
        return [
            'reason'  => ['required', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
