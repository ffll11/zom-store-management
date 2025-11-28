<?php

namespace App\Repositories;

use App\Filters\ProductFilter;
use App\Http\Resources\PromotionProductResource;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Interfaces\BaseRepository;
use App\Models\Promotion;
use Log;

class ProductRepository implements BaseRepository
{
    protected $productFilter;

    public function __construct(ProductFilter $productFilter)
    {
        $this->productFilter = $productFilter;
    }

    public function all($request){

        if (!Product::all()) {
            return "No products found";
        }

        if($request) {

          $queryItems = $this->productFilter->transform($request);

          if ($queryItems) {

            $products = Product::where($queryItems);
            if ($products->count() == 0) {
              return "No products match the given criteria.";
            }
              return ProductResource::collection($products->paginate(10)->appends($request->query()));
          }
        }

        Log::info('No filters applied, returning all products.');

        return ProductResource::collection(Product::all());
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
        if (! $id) {
            return null;
        }

        if(empty($id)){
            return "Id is required";
        }

        $product = Product::find($id);
        if ($product) {

            $product->delete();

            return response()->noContent();
        }
        return "Product not found";
    }


public function promotedProducts()
{
    // Just get products with their promotion relationships
    $products = Product::with(['promotionProducts.promotion'])
        ->whereHas('promotionProducts.promotion', function($query) {
            $query->active();
        })
        ->get();

    return ProductResource::collection($products);
}

public function activePromotions($request)
{
    $products = Product::with(['promotionProducts.promotion'])
        ->whereHas('promotionProducts.promotion', function ($query) use ($request) {
            $query->active();

            // Determine the promotion name from the passed value (accept either a string or a Request-like object)
            $name = is_string($request) ? $request : (is_object($request) && isset($request->name) ? $request->name : null);

            if ($name) {
                $name = trim($name);
                if (strpos($name, ' ') !== false && count(preg_split('/\s+/', $name)) > 1) {
                    $words = preg_split('/\s+/', $name);
                    $query->where(function($q) use ($words) {
                        foreach ($words as $word) {
                            $q->where('name', 'like', '%' . $word . '%');
                        }
                    });
                } else {
                    $query->where('name', $name);
                }
            }
        })
        ->get();

    // Attach calculated discounted price to each product so the resource can return it
    foreach ($products as $product) {
        $product->setAttribute('discounted_price', $this->calculateDiscountedPrice($product));
    }

    return ProductResource::collection($products);
}

public function calculateDiscountedPrice(Product $product)
{
    $promotionProduct = $product->promotionProducts()->with('promotion')->first();

    if ($promotionProduct && $promotionProduct->promotion) {
        $discount = $promotionProduct->promotion->discount_percentage;
        $discountedPrice = $product->sale_price * (1 - $discount / 100);
        return round($discountedPrice, 2);
    }

    return $product->sale_price;
}

}
