<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $doctorId = $this->route('doctor'); // null for create, model ID for update

        $rules = [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                // Safety net: prevent duplicate doctor names (case-insensitive via MySQL default collation)
                Rule::unique('doctors', 'name')->ignore($doctorId),
            ],
            'title' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            // When an image file is uploaded, validate as image; otherwise allow a URL string or null
            'image' => $this->hasFile('image')
                ? ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048']
                : ['nullable', 'string', 'max:500'],
            'experience' => ['nullable', 'string', 'max:100'],
            'reviews' => ['nullable', 'integer', 'min:0'],
            'education' => ['nullable', 'string', 'max:5000'],
            'schedule' => ['nullable', 'string', 'max:5000'],
            'bio' => ['nullable', 'string', 'max:10000'],
            'type' => ['sometimes', 'required', 'array'],
            'type.*' => ['required', 'string', 'in:consultant,outdoor'],
            'is_active' => ['nullable', 'boolean'],
        ];

        return $rules;
    }

    /**
     * Get custom validation error messages.
     */
    public function messages(): array
    {
        return [
            'name.unique' => 'A doctor with this name already exists. Duplicate names are not allowed.',
        ];
    }
}
