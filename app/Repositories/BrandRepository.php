<?php

namespace App\Repositories;

use App\Http\Resources\BrandResource;
use App\Interfaces\BaseRepository;
use App\Models\Brand;
use App\Models\Country;
use App\Models\Product;
use App\Query\ApiSearch;
use App\Query\ApiSort;
use Illuminate\Support\Facades\Log;

class BrandRepository implements BaseRepository
{
    public function all($request = null)
    {
        $request->validate([
            'order_by' => 'sometimes|in:asc,desc',
            'country_id' => 'sometimes|exists:countries,id',
            'page' => 'sometimes|integer|min:1',
        ]);

    }

    public function allBrands($request = null)
    {


        if ($request) {
            
            $query = Product::query();

            // Search
            $search = new ApiSearch(
                searchableFields: ['name', 'description'],
                columnMap: [
                    'name' => 'name',
                    'description' => 'description',
                ]
            );

            $query = $search->apply($request, $query) ?? $query;

            // Sort
            $sort = new ApiSort(
                allowedSorts: ['name_asc','name_desc'],
                columnMap: [
                    'name' => 'name',

                ]
            );

            $query = $sort->apply($request, $query) ?? $query;

            return BrandResource::collection($query->paginate(10)->appends($request->query()));

        }

        Log::info('Fetching all brands without filters');
        $brand = Brand::paginate(10);

        return BrandResource::collection($brand);

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
