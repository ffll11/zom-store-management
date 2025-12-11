<?php

namespace App\Filters\Query;

use Illuminate\Http\Request;

class QueryFilterSortingSearchable
{
    protected $builder;

    protected $request;

    protected $sorter;

    protected $searcher;

    protected $filter;

    public function __construct(Request $request, QuerySort $sorter, QuerySearch $searcher, QueryFilter $filter)
    {
        $this->request = $request;
        $this->sorter = $sorter;
        $this->searcher = $searcher;
        $this->filter = $filter;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        // Apply search first
        $this->builder = $this->searcher->apply($this->builder);

        // Then apply sorting
        $this->builder = $this->sorter->apply($this->builder);
        // Finally apply filtering
        $this->builder = $this->filter->apply($this->builder);

        return $this->builder;
    }
}