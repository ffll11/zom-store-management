<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255|unique:brands,name,',
            'slug' => 'sometimes|string|max:255|unique:brands,slug,' ,
            'description' => 'sometimes|string',
        ];
    }
}
