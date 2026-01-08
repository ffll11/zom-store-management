<?php

namespace App\Repositories;

use App\Filters\BrandFilter;
use App\Http\Resources\BrandResource;
use App\Interfaces\BaseRepository;
use App\Models\Brand;
use Illuminate\Support\Facades\Log;

class BrandRepository implements BaseRepository
{
    protected $brandFilter;

    public function __construct(BrandFilter $brandFilter)
    {
        $this->brandFilter = $brandFilter;
    }

    public function filteredBrand($request)
    {
        if (! Brand::all()) {
            return 'No brands found';
        }
        if ($request) {

            $queryItems = $this->brandFilter->transform($request);

            if ($queryItems) {

                $brands = Brand::where($queryItems);
                if ($brands->count() == 0) {
                    return 'No brands match the given criteria.';
                }

                return BrandResource::collection($brands->paginate(10)->appends($request->query()));
            }
        }

        return BrandResource::collection(Brand::paginate(10));
    }

    public function all($request)
    {

        if (! Brand::all()) {
            return 'No brands found';
        }

        Log::info('Fetching all brands');

        return BrandResource::collection(resource: Brand::all());
    }

    public function getName()
    {
        if (! Brand::all()) {
            return 'No brands found';
        }

        return BrandResource::collection(resource: Brand::get(['id', 'name']));

    }

    public function find($id)
    {
        if (empty($id)) {
            return 'Id is required';
        }

        $brand = Brand::find($id);
        if ($brand) {
            return new BrandResource($brand);
        }

        return 'Brand not found';
    }

    public function create(array $attributes)
    {
        if (! $attributes) {
            return 'Attributes are required';
        }

        return new BrandResource(resource: Brand::create($attributes));
    }

    public function update($id, array $attributes)
    {
        if (empty($id)) {
            return 'Id is required';
        }

        if (empty($attributes)) {
            return 'Attributes are required';
        }

        $brand = Brand::find($id);

        if ($brand) {

            $brand->update($attributes);

            return new BrandResource($brand);
        }

        return 'Brand not found';
    }

    public function delete($id)
    {
        if (! $id) {
            return null;
        }

        if (empty($id)) {
            return 'Id is required';
        }

        $brand = Brand::find(id: $id);
        if ($brand) {

            $brand->delete();

            return response()->noContent();

        }

        return 'Brand not found';
    }
}
