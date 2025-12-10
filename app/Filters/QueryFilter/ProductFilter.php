<?php
namespace App\Filters\QueryFilter;
use App\Filters\QueryFilter\QueryFilter;

class ProductFilter extends QueryFilter {
    // You can add specific filter methods here if needed

    public function brand($brandId)
    {
        return $this->builder->where('brand_id', $brandId);
    }

    public function subfamily($subfamilyId)
    {
        return $this->builder->where('subfamily_id', $subfamilyId);
    }

    public function name($name)
    {
        $names = explode(' ', $name);
        foreach ($names as $n) {
            $this->builder->where('name', 'like', "%{$n}%");
        }
        return $this->builder;
    }

    public function priceRange($min, $max)
    {
        return $this->builder->whereBetween('price', [$min, $max]);
    }
}