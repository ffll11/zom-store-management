<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubfamilyRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:subfamilies,name,' . $this->subfamily->id,
            'slug' => 'required|string|max:255|unique:subfamilies,slug,' . $this->subfamily->id,
            'description' => 'nullable|string',
            'family_id' => 'required|exists:families,id',
        ];
    }
}
