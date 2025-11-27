<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'image' => $this->image_url,
            'description' => $this->description,
            'price' => $this->price,
            'category_slug' => $this->subfamily->family->subcategory->category->slug,
            'subcategory_slug' => $this->subfamily->family->subcategory->slug,
            'family_slug' => $this->subfamily->family->slug,
            'subfamily_slug' => $this->subfamily->slug,
            'brand_slug' => $this->brand->slug,

        ];
    }
}
