<?php

namespace App\Repositories;

use App\Filters\ProductFilter;
use App\Http\Resources\ProductPaginateResource;
use App\Http\Resources\ProductResource;
use App\Interfaces\BaseRepository;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductRepository implements BaseRepository
{
    protected $productFilter;

    public function __construct(ProductFilter $productFilter)
    {
        $this->productFilter = $productFilter;
    }

    public function all($request)
    {

        $query = Product::query();
        $query = $this->productFilter->apply($query);

        if ($query->count() === 0) {
            return response()->json([
                'message' => 'No products match the given criteria.',
            ], 404);
        }

        Log::info('Fetching filtered products.');

        $products = $query->paginate(
            10,
            ['*'],
            'page',
            $request->get('page', 1)
        );

        return ProductPaginateResource::collection($products);
    }

    public function getProducts()
    {

        if (! Product::all()) {
            return 'No products found';
        }
        Log::info('Fetching all products without filters.');

        return ProductResource::collection(Product::all());
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
