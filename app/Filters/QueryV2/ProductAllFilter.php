<?php

namespace App\Filters\QueryV2;

class ProductAllFilter extends QueryAllFilter
{
    // Where has the brand id in array
    public function brand($brandIds)
    {
        $ids = explode(',', $brandIds);

        return $this->builder->whereIn('brand_id', $ids);
    }

    // Where has the category id in array
    public function subfamily($subfamilyIds)
    {
        $ids = explode(',', $subfamilyIds);

        return $this->builder->whereIn('subfamily_id', $ids);
    }

    // Search the name field
    public function name($value)
    {
        return $this->searchIn(['name'], $value);
    }

    // Search the description field
    public function description($value)
    {
        return $this->searchIn(['description'], $value);
    }

    // Order by field_direction
    public function orderBy($value)
    {
        if (str_contains($value, '_')) {
            $part = explode('_', $value);
            $direction = array_pop($part); // last part is direction
            $field = implode('_', $part); // rest is field

            $direction = in_array(strtolower($direction), ['asc', 'desc']) ? $direction : 'asc';

            return $this->builder->orderBy($field, $direction);
        }
    }
}
