<?php

namespace App\Repositories;

use App\Http\Resources\BrandResource;
use App\Interfaces\BaseRepository;
use App\Models\Brand;

class BrandRepository implements BaseRepository
{

    public function all()
    {   
        return BrandResource::collection(Brand::all());
    }

    public function find($id)
    {
        return new BrandResource(Brand::find($id));
    }

    public function create(array $attributes)
    {
        return new BrandResource(Brand::create($attributes));
    }

    public function update($id, array $attributes)
    {
        $brand = $this->find($id);
        if ($brand) {
            $brand->update($attributes);
            return $brand;
        }
        return null;
    }

    public function delete($id)
    {
        $brand = $this->find($id);
        if ($brand) {
            return $brand->delete();
        }
        return false;
    }
}

