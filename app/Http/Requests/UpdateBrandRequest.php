<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        logger()->info('UpdateBrandRequest debug', [
            'route_id' => $this->route('brand')->id,
            'payload' => $this->all(),
        ]);

       return [
        'name' => [
            'sometimes',
            'string',
            'max:255',
            Rule::unique('brands', 'name')->ignore($this->route('brand')->id),
        ],
        'slug' => [
            'sometimes',
            'string',
            'max:255',
            Rule::unique('brands', 'slug')->ignore($this->route('brand')->id),
        ],
        'description' => 'sometimes|string',
        'country_id' => 'sometimes|integer|exists:countries,id',
    ];
    }
}
