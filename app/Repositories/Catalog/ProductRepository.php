<?php

namespace App\Repositories\Catalog;

use App\Filters\QueryV2\ProductAllFilter;
use App\Http\Resources\ProductPaginateResource;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Family;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Subfamily;
use App\Services\MenuContextResolver;
use App\Traits\ApiResponse\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductRepository
{
    use ApiResponse;

    public function getOnSaleProducts()
    {

        $products = Product::where('is_on_sale', 1)
            ->where('is_active', 1)
            ->get();

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
        $query = Product::active()
            ->when($term, function ($query, $term) {
                $search = is_array(value: $term) ? implode(' ', $term) : $term;
                $words = preg_split('/\s+/', trim($search));
                $query->where(function ($q) use ($words) {
                    foreach (array_filter($words) as $word) {
                        $q->orWhere('name', 'like', '%'.$word.'%');
                    }
                });
            });

        $products = $query->paginate(10);

        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'No products match the given criteria.',
                'data' => [],
            ]);
        }

        return ProductResource::collection($products);
    }

    public function catalog(ProductAllFilter $filters, Request $request, string $slug)
    {
        Log::info('ProductRepository: filters called with request: '.json_encode($request->all()));

        // 1️⃣ Base query
        $query = Product::active()->with('brand', 'subfamily');

        // 2️⃣ MENU CONTEXT (if present)
        // MENU CONTEXT
        $query = MenuContextResolver::apply($query, $slug);

        // FILTERS
        $query = $filters->apply($query);

        $products = $query->paginate(
            10,
            ['*'],
            'page',
            $request->query('page', 1)
        );

        return $this->successResponse(
            new ProductPaginateResource($products),
            'Products retrieved successfully'
        );
    }

    /*
        public function catalog($slug)
        {
            Log::info("CatalogController: catalog called with slug: $slug");

            // 1. Brand
            if ($brand = Brand::where('slug', $slug)->first()) {
                $products = Product::where('brand_id', $brand->getKey())->active()->with('Brand')->paginate(10);

                return $this->successResponse(
                    new ProductPaginateResource($products),
                    'Products retrieved successfully'
                );
            }

            // 2. Category (through subcategories → subfamilies → families)
            if ($category = Category::where('slug', $slug)->first()) {
                $products = Product::whereHas('subfamily.family.subcategory', function ($q) use ($category) {
                    $q->where('category_id', $category->getKey());
                })->active()->paginate(10);

                return new ProductPaginateResource($products);
            }

            // 3. Subcategory
            if ($subcategory = Subcategory::where('slug', $slug)->first()) {
                $products = Product::whereHas('subfamily.family', function ($q) use ($subcategory) {
                    $q->where('subcategory_id', $subcategory->getKey());
                })->active()->paginate(10);

                return new ProductPaginateResource($products);
            }

            // 4. Family
            if ($family = Family::where('slug', $slug)->first()) {
                $products = Product::whereHas('subfamily', function ($q) use ($family) {
                    $q->where('family_id', $family->getKey());
                })->active()->paginate(10);

                return new ProductPaginateResource($products);
            }

            // 5. Subfamily
            if ($subfamily = Subfamily::where('slug', $slug)->first()) {
                $products = Product::where('subfamily_id', $subfamily->getKey())->active()->paginate(10);

                return new ProductPaginateResource($products);
            }

            abort(404);
        } */
}
