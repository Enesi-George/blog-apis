<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|url',
        ];

        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $rules['title'] = 'sometimes|required|string|max:255';
            $rules['description'] = 'sometimes|required|string';
        }

        return $rules;
    }
}
