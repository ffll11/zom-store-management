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
            'subfamily' => $this->subfamily->name,
            'brand' => $this->brand->name,
            'family' => $this->family->name,

        ];
    }
}
