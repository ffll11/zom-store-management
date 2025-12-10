<?php

namespace App\Filters\QueryFilter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QueryFilter
{
    protected $builder;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function filter($arr)
    {

        foreach ($arr as $key => $value) {

            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->builder;

    }

    // Include
    // NOW ARE APPLING THE POSSIBILITY TO SEARCH AND BRING THE INCLUDE THAT WE WANT
    public function include($value)
    {
        $sort = explode(',', $value);
        $list = collect([]);

        // We iterate over the sort array
        foreach ($sort as $item) {
            // If does have the  realtion
            if (in_array($item, $this->builder->getModel()->getRelations())) {
                $list->push($item);
            }

        }

        $this->builder->with($list->all());
    }

    public function apply(Builder $builder)
    {

        $this->builder = $builder;

        foreach ($this->request->all() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $builder;

    }
}
