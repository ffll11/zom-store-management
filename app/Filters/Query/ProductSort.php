<?php

namespace App\Filters\Query;

use Illuminate\Http\Request;

class ProductSort extends QuerySort
{
    // You can add specific sorting methods here if needed
        public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function price($direction)
    {
        return $this->builder->orderBy('price', $direction);
    }

    public function name($direction)
    {
        return $this->builder->orderBy('name', $direction);
    }
}
