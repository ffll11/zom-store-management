<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionProductResource extends JsonResource
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
            'promotion' => new PromotionResource($this->whenLoaded('promotion')),
            'product' => new ProductResource($this->whenLoaded('product')),
            'subcategory_slug' => $this->product->subfamily->family->subcategory->slug,
        ];

    }
}
