<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Family;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Subfamily;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\Environment\Console;

class CatalogController extends Controller
{
    public function catalog($slug)
    {
        Log::info("CatalogController: catalog called with slug: $slug");
        // find brand or fail
        $brand = Brand::where('slug', $slug)->firstOrFail();

        if ($brand) {
            $products = Product::where('brand_id', $brand->id)->get();

             $response  = response()->json([
                'type' => 'brand',
                'slug' => $slug,
                'title' => $brand->name,
                'products' => ProductResource::collection($products),
            ]);

            Log::info("CatalogController: catalog response: " . $response->getContent());   

            return $response;

            //Add console log for debugging purposes response

        }

        // return products by category

        $category = Category::where('slug', $slug)->firstOrFail();

        if ($category) {
            $products = Product::where('category_id', operator: $category->id)->get();

            return response()->json([
                'type' => 'category',
                'slug' => $slug,
                'title' => $category->name,
                'products' => ProductResource::collection($products),
            ]);
        }

        // reruen by subcategory
        $subcategory = Subcategory::where('slug', $slug)->firstOrFail();

        if ($subcategory) {
            $products = Product::where('subcategory_id', $subcategory->getKey())->get();

            return response()->json([
                'type' => 'subcategory',
                'slug' => $slug,
                'title' => $subcategory->name,
                'products' => ProductResource::collection($products),
            ]);
        }

        // return by family
        $family = Family::where('slug', $slug)->firstOrFail();

        if ($family) {
            $products = Product::where('family_id', $family->getKey())->get();

            return response()->json([
                'type' => 'family',
                'slug' => $slug,
                'title' => $family->name,
                'products' => ProductResource::collection($products),
            ]);
        }

        // return by subfamily
        $subfamily = Subfamily::where('slug', $slug)->firstOrFail();

        if ($subfamily) {
            $products = Product::where('subfamily_id', $subfamily->id)->get();

            return response()->json([
                'type' => 'subfamily',
                'slug' => $slug,
                'title' => $subfamily->name,
                'products' => ProductResource::collection($products),
            ]);
        }

        abort(404);

    }
}
