<?php

namespace App\Repositories;

use App\Http\Resources\BrandResource;
use App\Interfaces\BaseRepository;
use App\Models\Brand;
use App\Models\Country;
use App\Models\Product;
use App\Query\ApiSearch;
use App\Query\ApiSort;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class BrandRepository implements BaseRepository
{
    public function all($request)
    {
        if ($request) {
            Log::info('Fetching all brands with filters.');

            $request->validate([
                'search' => 'nullable|string|min:1',
                'sort' => 'nullable|string',
                'order' => 'nullable|in:asc,desc',
                'per_page' => 'sometimes|integer|min:1|max:100',
            ]);

            $allowedSorts = ['id', 'name', 'email', 'created_at'];
            $query = Brand::query();

            // Search
            if ($request->has('search')) {
                $query->where(function ($que) use ($request) {
                    $que->where('name', 'like', '%'.$request->query('search').'%')
                        ->orWhere('description', 'like', '%'.$request->query('search').'%');
                });
            }

            // Sort
            if ($request->has('sort') && in_array($request->query('sort'), $allowedSorts)) {
                $order = $request->query('order', 'asc');
                $query->orderBy($request->query('sort'), $order);
            }

            $perPage = $request->query('per_page', 10);

            return BrandResource::collection($query->paginate($perPage)->appends($request->query()));
        }

        Log::info('Fetching all brands without filters.');
        $brand = Brand::query()->paginate(10);

        return BrandResource::collection($brand);
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
                allowedSorts: ['name_asc', 'name_desc'],
                columnMap: [
                    'name' => 'name',
                ]
            );

            $query = $sort->apply($request, $query) ?? $query;

            return BrandResource::collection($query->paginate(10)->appends($request->query()));

        }

        Log::info('Fetching all brands without filters');
        $brand = Brand::query()->paginate(10);

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

    public function update($id, array $attributes): Brand
    {
        $brand = Brand::find($id);

        if (! $brand) {
            throw new ModelNotFoundException('Brand not found');
        }

        Log::info("Updating brand id {$id}", $attributes);

        $brand->update($attributes);

        return $brand->fresh();
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

        return json_encode('Brand not found');
    }
}
