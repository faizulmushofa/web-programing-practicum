<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:255',
            'url_image' => 'nullable|url',
            'rating' => 'nullable|numeric|min:0|max:100',
            'episodes' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|in:current,finished,ongoing'
        ];
    }
}
