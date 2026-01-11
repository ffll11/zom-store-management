<?php

namespace App\Filters;

class BrandFilter extends QueryFilter
{
    public function orderBy($query, $value)
    {
        $query->orderBy('name', $value);
    }

    public function descending($query, $value)
    {
        if ($value) {
            $query->orderBy('created_at', 'desc');
        }
    }

    public function ascending($query, $value)
    {
        if ($value) {
            $query->orderBy('created_at', 'asc');
        }
    }

    public function search($query, $value)
    {
        $query->where('name', 'LIKE', "%{$value}%")
              ->orWhere('description', 'LIKE', "%{$value}%");
    }
}
