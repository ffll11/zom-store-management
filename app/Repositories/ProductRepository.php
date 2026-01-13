<?php

namespace App\Repositories;

use App\Http\Resources\ProductResource;
use App\Interfaces\BaseRepository;
use App\Models\Product;
use App\Query\ApiSearch;
use App\Query\ApiSort;
use Illuminate\Support\Facades\Log;

class ProductRepository implements BaseRepository
{
    protected $productFilter;

    public function all($request = null)
    {
        if ($request) {
            $query = Product::query();

            // Search
            $search = new ApiSearch(
                searchableFields: ['name', 'description', 'sku'],
                columnMap: [
                    'name' => 'name',
                    'description' => 'description',
                    'sku' => 'sku',
                ]
            );

            $query = $search->apply($request, $query) ?? $query;

            // Sort

            $sort = new ApiSort(
                allowedSorts: ['name_asc', 'name_desc', ],
                columnMap: [
                    'name' => 'name',

                ]
            );

            $query = $sort->apply($request, $query) ?? $query;

            return ProductResource::collection($query->paginate(10)->appends($request->query()));

        }

        Log::info('Fetching all products without filters.');
        $products = Product::paginate(10);

        return ProductResource::collection($products);

    }

    public function find($id)
    {
        if (empty($id)) {
            return 'Id is required';
        }

        $product = Product::find($id);
        if ($product) {
            return new ProductResource($product);
        }

        return 'Product not found';
    }

    public function create(array $attributes)
    {
        if (! $attributes) {
            return 'Attributes are required';
        }

        return new ProductResource(resource: Product::create($attributes));
    }

    public function update($id, array $attributes)
    {
        if (empty($id)) {
            return 'Id is required';
        }

        if (! $attributes) {
            return 'Attributes are required';
        }

        $product = Product::find($id);
        if ($product) {
            $product->update($attributes);

            return new ProductResource($product);
        }

        return 'Product not found';
    }

    public function delete($id)
    {
        if (! $id) {
            return null;
        }

        if (empty($id)) {
            return 'Id is required';
        }

        $product = Product::find($id);
        if ($product) {

            $product->delete();

            return response()->noContent();
        }

        return 'Product not found';
    }
}
