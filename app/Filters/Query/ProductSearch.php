<?php

namespace App\Filters\Query;

use Illuminate\Http\Request;

class ProductSearch extends QuerySearch 
{
    // You can add specific search methods here if needed
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function name($name)
    {
        $names = explode(' ', $name);
        foreach ($names as $n) {
            $this->builder->where('name', 'like', "%{$n}%");
        }
        return $this->builder;
    }

    public function description($description)
    {
        $descriptions = explode(' ', $description);
        foreach ($descriptions as $d) {
            $this->builder->where('description', 'like', "%{$d}%");
        }
        return $this->builder;
    }
}