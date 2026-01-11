<?php

namespace App\Repositories;

use App\Filters\BrandFilter;
use App\Http\Resources\BrandPaginateResource;
use App\Http\Resources\BrandResource;
use App\Interfaces\BaseRepository;
use App\Models\Brand;
use App\Models\Country;
use Illuminate\Support\Facades\Log;

class BrandRepository implements BaseRepository
{
    protected $brandFilter;

    public function __construct(BrandFilter $brandFilter)
    {
        $this->brandFilter = $brandFilter;
    }

    public function all($request)
    {
        $query = Brand::query();
        $query = $this->brandFilter->apply($query);
        if ($query->count() === 0) {
            return response()->json([
                'message' => 'No brands match the given criteria.',
            ], 404);
        }
        Log::info('Fetching filtered brands.');

        $brands = $query->paginate(
            10,
            ['*'],
            'page',
            $request->get('page', 1)
        );

        return BrandPaginateResource::collection($brands);
    }

    public function getNameBrand()
    {
        Log::info('Fetching brand names');

        $brands = Brand::query()->select('id', 'name')->get();

        Log::info('Brand names fetched: '.$brands->count().' records');

        return response()->json($brands, 200);
    }

    public function getCountries()
    {
        Log::info('Fetching brand countries');

        $countries = Country::query()->select('id', 'name')->get();

        Log::info('Brand countries fetched: '.$countries->count().' records');

        return response()->json($countries, 200);
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
