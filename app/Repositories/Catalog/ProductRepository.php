<?php

namespace App\Repositories\Catalog;

use App\Filters\ProductFilter;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductRepository
{
    protected $productFilter;

    public function __construct(ProductFilter $productFilter)
    {
        $this->productFilter = $productFilter;
    }

    public function getOnSaleProducts()
    {

        $products = Product::where('is_on_sale', 1)
            ->where('is_active', 1)
            ->get();

        foreach ($products as $product) {
            if ($product->price && $product->sale_price) {
                $product->percentage_discount = $this->getPercentageDiscount($product->price, $product->sale_price);
            }
        }

        return ProductResource::collection($products);
    }

    public function getLatestProducts()
    {
        try {
            $products = Product::where('is_active', 1)
                ->latest()
                ->limit(4)
                ->get();

            return ProductResource::collection($products);

        } catch (\Exception $e) {
            Log::error('Failed to fetch latest products: '.$e->getMessage());

            return ProductResource::collection([]);
        }
    }

    public function getNavProducts($ids)
    {
        $products = Product::with(['category', 'subcategory', 'brand', 'family', 'subfamily'])
            ->active()
            ->whereIn('id', $ids)
            ->get();

        return ProductResource::collection($products);

    }

    public function find($slug)
    {
        if (empty($slug)) {
            return 'Slug is required';
        }

        $product = Product::active()
            ->where('slug', $slug)
            ->firstOrFail();
        if ($product) {
            return new ProductResource($product);
        }

        return response()->json(['message' => 'Product not found'], 404);
    }

    // Search by name
    public function search($term)
    {

        $products = Product::active()
            ->when($term, function ($query, $term) {
                $query->where('name', 'like', '%'.$term.'%');
            })
            ->get();

        if ($products->count() == 0) {
            return 'No products match the given criteria.';
        }

        return ProductResource::collection($products->paginate(10)->appends($term->query()));
    }

    public function filters($params)
    {
        $query = Product::query()->active();

        $filterItems = $this->productFilter->transform($params);

        foreach ($filterItems as $item) {
            $query->where($item['column'], $item['operator'], $item['value']);
        }

        $products = $query->get();

        return ProductResource::collection($products->paginate(10)->appends($params));
    }

    public function getAllProducts()
    {
        try {
            $products = Product::where('is_active', 1)->get();

            return ProductResource::collection($products);
        } catch (\Exception $e) {
            Log::error('Error fetching all products: '.$e->getMessage());

            return ProductResource::collection([]);
        }
    }

    public function getPercentageDiscount($originalPrice, $salePrice)
    {
        if ($originalPrice <= 0) {
            return 0;
        }

        $discount = $originalPrice - $salePrice;
        $percentage = ($discount / $originalPrice) * 100;

        return round($percentage, 2);
    }
}
