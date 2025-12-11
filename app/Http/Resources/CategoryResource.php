<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'description' => $this->description,
            'subcategories' =>SubcategoryResource::collection($this->whenLoaded('subcategories')),
            'families' =>FamilyResource::collection($this->whenLoaded('subcategories.families')),
            'subfamilies' =>SubfamilyResource::collection($this->whenLoaded('subcategories.families.subfamilies')),
        ];
    }
}
