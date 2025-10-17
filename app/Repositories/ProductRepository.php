<?php

namespace App\Repositories;

use App\Filters\ProductFilter;
use App\Models\Product;;
use App\Http\Resources\ProductResource;
use App\Interfaces\BaseRepository;

class ProductRepository implements BaseRepository
{
    protected $productFilter;

    public function __construct(ProductFilter $productFilter)
    {
        $this->productFilter = $productFilter;
    }

    public function all($request)
    {
        if(!isset($request)) {

            if(!Product::all()) {
                return "No products found";
            }

            return ProductResource::collection(Product::all());
        }else{

            
        }

    }

    public function find($id)
    {
        if (empty($id)) {
            return "Id is required";
        }

        $product = Product::find($id);
        if ($product) {
            return new ProductResource($product);
        }
        return "Product not found";
    }

    public function create(array $attributes)
    {
        if (!$attributes) {
            return "Attributes are required";
        }

        return new ProductResource(resource: Product::create($attributes));
    }

    public function update($id, array $attributes)
    {
        if (empty($id)) {
            return "Id is required";
        }

        if (!$attributes) {
            return "Attributes are required";
        }

        $product = Product::find($id);
        if ($product) {
            $product->update($attributes);
            return new ProductResource($product);
        }
        return "Product not found";
    }

    public function delete($id)
    {
        if (empty($id)) {
            return "Id is required";
        }

        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return "Product deleted successfully";
        }
        return "Product not found";
    }

}
