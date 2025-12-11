<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductPaginateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'data' => ProductResource::collection($this->resource->items()), // Use $this->resource
            'pagination' => [
                'total' => $this->resource->total(), // Use $this->resource
                'current_page' => $this->resource->currentPage(), // Use $this->resource
                'last_page' => $this->resource->lastPage(), // Use $this->resource
                'per_page' => $this->resource->perPage(), // Use $this->resource
                'from' => $this->resource->firstItem(), // Use $this->resource
                'to' => $this->resource->lastItem(), // Use $this->resource
            ],
        ];
    }
}
