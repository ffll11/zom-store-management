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
            'id' => $this->uuid,
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'image' => $this->image_url,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'is_on_sale' => $this->is_on_sale,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'brand' => $this->brand ? $this->brand->name : null,
            'brandSlug' => $this->brand ? $this->brand->slug : null,
        ];
    }
}
