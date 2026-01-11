<?php

namespace App\Filters;

class ProductFilter extends QueryFilter
{
    public function orderBy($query, $value)
    {
        $query->orderBy('price', $value);
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
        $query->where(function ($q) use ($value) {
            $q->where('name', 'LIKE', "%{$value}%")
                ->orWhere('description', 'LIKE', "%{$value}%");
        });
    }
}
