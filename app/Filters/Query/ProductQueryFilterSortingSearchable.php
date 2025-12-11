<?php
namespace App\Filters\Query;

class ProductQueryFilterSortingSearchable {

    protected $sorter;
    protected $searcher;
    protected $filter;
    public function __construct(ProductSort $sorter, ProductSearch $searcher ,ProductFilter $filter) {
        $this->sorter = $sorter;
        $this->searcher = $searcher;
        $this->filter = $filter;
       
    }

    public function apply($builder) {
        // Apply search first
        $builder = $this->searcher->apply($builder);

        // Then apply filtering
        $builder = $this->filter->apply($builder);

        // Finally apply sorting
        $builder = $this->sorter->apply($builder);

        return $builder;
    }
}   