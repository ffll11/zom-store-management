<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($query)
    {
        foreach ($this->request->all() as $name => $value) {
            if (method_exists($this, $name) && $value !== null) {
                $this->$name($query, $value);
            }
        }

        return $query;
    }

}
