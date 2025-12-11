<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NabvarResource extends JsonResource
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
            'categories' =>CategoryResource::collection($this->whenLoaded('categories')),
            'subcategories' =>SubcategoryResource::collection($this->whenLoaded('subcategories')),
            'families' =>FamilyResource::collection($this->whenLoaded('families')),
            'subfamilies' =>SubfamilyResource::collection($this->whenLoaded('subfamilies')),
        ];
    }
}
