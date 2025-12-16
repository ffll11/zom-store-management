<?php

namespace App\Filters\QueryV2;

class ProductAllFilter extends QueryAllFilter
{
    // Where has the brand id in array
    public function brand($brandIds)
    {
        $ids = explode(',', $brandIds);

         $this->builder->whereIn('brand_id', $ids);
    }

    // Where has the category id in array
    public function subfamily($subfamilyIds)
    {
        $ids = explode(',', $subfamilyIds);

         $this->builder->whereIn('subfamily_id', $ids);
    }

    // Search the name field
    public function name($value)
    {
         $this->searchIn(['name'], $value);
    }

    // Search the description field
    public function description($value)
    {
         $this->searchIn(['description'], $value);
    }

    // Order by field_direction
    public function orderBy($value)
    {
        if (str_contains($value, '_')) {
            $part = explode('_', $value);
            $direction = array_pop($part); // last part is direction
            $field = implode('_', $part); // rest is field

            $direction = in_array(strtolower($direction), ['asc', 'desc']) ? $direction : 'asc';

             $this->builder->orderBy($field, $direction);
        }
    }

    public function menuSlug($value)
    {
        // 1. Brand
        if ($brand = \App\Models\Brand::where('slug', $value)->first()) {
            return $this->builder->where('brand_id', $brand->id);
        }

        // 2. Category
        if ($category = \App\Models\Category::where('slug', $value)->first()) {
            return $this->builder->whereHas('subfamily.family.subcategory', function ($q) use ($category) {
                $q->where('category_id', $category->id);
            });
        }

        // 3. Subcategory
        if ($subcategory = \App\Models\Subcategory::where('slug', $value)->first()) {
            return $this->builder->whereHas('subfamily.family', function ($q) use ($subcategory) {
                $q->where('subcategory_id', $subcategory->id);
            });
        }

        // 4. Family
        if ($family = \App\Models\Family::where('slug', $value)->first()) {
            return $this->builder->whereHas('subfamily', function ($q) use ($family) {
                $q->where('family_id', $family->id);
            });
        }

        abort(404);
    }
}
