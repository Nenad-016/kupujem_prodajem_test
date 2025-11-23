<?php

namespace App\Http\Requests;

use App\Enums\AdStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'condition' => ['required', Rule::in(['new', 'used'])],
            'status' => [
                'sometimes',
                Rule::in(array_column(AdStatus::cases(), 'value')),
            ],
            'phone' => ['nullable', 'string', 'max:50'],
        ];
    }
}
