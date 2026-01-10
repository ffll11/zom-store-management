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
            'is_active' => $this->is_active,
            'is_on_sale' => $this->is_on_sale,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
           // 'brand' => new BrandResource($this->whenLoaded('Brand')),
            //'subfamily' => new SubfamilyResource($this->whenLoaded('Subfamily')),
            'brand_id' => $this->brand->id,
            'subfamily_id' => $this->subfamily->id,
            'brand_name' => $this->brand->name,
            'subfamily_name' => $this->subfamily->name,
            'brand_slug' => $this->brand->slug,
        ];
    }
}
