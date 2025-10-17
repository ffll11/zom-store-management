<?php

namespace App\Repositories;

use App\Http\Resources\BrandResource;
use App\Interfaces\BaseRepository;
use App\Models\Brand;
use Illuminate\Support\Facades\Log;

class BrandRepository implements BaseRepository
{

    public function all()
    {
        if (!Brand::all()) {
            return "No brands found";
        }

        return BrandResource::collection(Brand::paginate(10));
    }

    public function find($id)
    {
        if (empty($id)) {
            return "Id is required";
        }

        $brand = Brand::find($id);
        if ($brand) {
            return new BrandResource($brand);
        }
        return "Brand not found";
    }

    public function create(array $attributes)
    {
        if (!$attributes) {
            return "Attributes are required";
        }

        return new BrandResource(resource: Brand::create($attributes));
    }

    public function update($id, array $attributes)
    {
        if (empty($id)) {
            return "Id is required";
        }

        if (empty($attributes)) {
            return "Attributes are required";
        }

        $brand = Brand::find($id);


        if ($brand) {
            Log::info("Updating brand id {$id} with attributes: " . json_encode($attributes));

            $brand->update($attributes);

            Log::info("Brand updated successfully: " . json_encode($brand));

            return new BrandResource($brand);
        }
        return "Brand not found";
    }

    public function delete($id)
    {
        if (! $id) {
            return null;
        }

        if(empty($id)){
            return "Id is required";
        }

        $brand = Brand::find(id: $id);
        if ($brand) {

            $brand->delete();

            return "Brand deleted successfully";
        }
        return "Brand not found";
    }
}

