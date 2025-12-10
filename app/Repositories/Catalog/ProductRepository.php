<?php

namespace App\Repositories\Catalog;

use App\Filters\ProductFilter;
use App\Http\Resources\CatalogResource;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Family;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Subfamily;
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
                $search = is_array($term) ? implode(' ', $term) : $term;
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
    /*     public function filters($params)
        {
            $query = Product::query()->active();

            $filterItems = $this->productFilter->transform($params);

            foreach ($filterItems as $item) {
                $query->where($item['column'], $item['operator'], $item['value']);
            }

            // Filter by brand
            if ($params->has('brand_ids')) {
                $query->whereIn('brand_id', explode(',', $params->brand_ids));
            }

            // Filter by subfamily
            if ($params->has('subfamily_ids')) {
                $query->whereIn('subfamily_id', explode(',', $params->subfamily_ids));
            }

            // Sorting logic
            if (isset($params['sort'])) {
                switch ($params['sort']) {
                    case 'latest':
                        $query->orderBy('created_at', 'desc');
                        break;

                    case 'price_asc':
                        $query->orderBy('price', 'asc');
                        break;

                    case 'price_desc':
                        $query->orderBy('price', 'desc');
                        break;
                }
            }

            // Apply pagination directly on query
            return ProductResource::collection(
                $query->paginate(10)->appends($params)
            );
        } */

    public function filters($params)
    {
        Log::info('ProductRepository: filters called', ['params' => $params->all()]);

        $queryfilters = $this->productFilter->transform($params);
        Log::info('ProductRepository: transformed filters', ['filters' => $queryfilters]);

        $products = Product::query()->active();
        // Apply filters
        // Apply filters
        if (! empty($transformed['filters'])) {
            $products->where($queryfilters['filters']);
        }

        Log::info('ProductRepository: products query built');

        $paginated = $products->paginate(10)->appends($params);
        Log::info('ProductRepository: filters result count', ['count' => $paginated->count()]);

        return ProductResource::collection($paginated);
    }

    public function catalog($slug)
    {
        Log::info("CatalogController: catalog called with slug: $slug");

        // 1. Brand
        if ($brand = Brand::where('slug', $slug)->first()) {
            $products = Product::where('brand_id', $brand->id)->active()->get(['name', 'price', 'sale_price', 'image_url', 'is_on_sale']);

            $response = new CatalogResource((object) [
                'title' => $brand->name,
                'products' => $products,
            ]);

            Log::info('CatalogController: catalog response: '.$response->toJson());

            return $response;
        }

        // 2. Category (through subcategories → subfamilies → families)
        $category = Category::where('slug', $slug)->first();
        if ($category) {
            $products = Product::whereHas('subfamily.family.subcategory', function ($q) use ($category) {
                $q->where('category_id', $category->id);
            })->active()->get(['name', 'price', 'sale_price', 'image_url', 'is_on_sale']);

            return new CatalogResource((object) [
                'title' => $category->name,
                'products' => $products,
            ]);
        }

        // 3. Subcategory
        $subcategory = Subcategory::where('slug', $slug)->first();
        if ($subcategory) {
            $products = Product::whereHas('subfamily.family', function ($q) use ($subcategory) {
                $q->where('subcategory_id', $subcategory->id);
            })->active()->get(['name', 'price', 'sale_price', 'image_url', 'is_on_sale']);

            return new CatalogResource((object) [
                'title' => $subcategory->name,
                'products' => $products,
            ]);
        }

        // 4. Family
        $family = Family::where('slug', $slug)->first();
        if ($family) {
            $products = Product::whereHas('subfamily', function ($q) use ($family) {
                $q->where('family_id', $family->id);
            })->active()->get(['name', 'price', 'sale_price', 'image_url', 'is_on_sale']);

            return new CatalogResource((object) [
                'title' => $family->name,
                'products' => $products,
            ]);
        }

        // 5. Subfamily
        $subfamily = Subfamily::where('slug', $slug)->first();
        if ($subfamily) {
            $products = Product::where('subfamily_id', $subfamily->id)->active()->get(['name', 'price', 'sale_price', 'image_url']);

            return new CatalogResource((object) [
                'title' => $subfamily->name,
                'products' => $products,
            ]);
        }

        abort(404);
    }
}
