<?php

namespace App\Services;

use App\Models\{
    Brand, Category, Subcategory, Family, Subfamily
};

class MenuContextResolver {

    public static function apply($query , $menuSlug) {
        // 1. Brand
        if ($brand = Brand::where('slug', $menuSlug)->first()) {
            return $query->where('brand_id', $brand->id);
        }

        // 2. Category
        if ($category = Category::where('slug', $menuSlug)->first()) {
            return $query->whereHas('subfamily.family.subcategory', function ($q) use ($category) {
                $q->where('category_id', $category->id);
            });
        }

        // 3. Subcategory
        if ($subcategory = Subcategory::where('slug', $menuSlug)->first()) {
            return $query->whereHas('subfamily.family', function ($q) use ($subcategory) {
                $q->where('subcategory_id', $subcategory->id);
            });
        }

        // 4. Family
        if ($family = Family::where('slug', $menuSlug)->first()) {
            return $query->whereHas('subfamily', function ($q) use ($family) {
                $q->where('family_id', $family->id);
            });
        }

        abort(404);

    }
}
