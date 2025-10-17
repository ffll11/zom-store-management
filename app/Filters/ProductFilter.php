<?php

namespace App\Filters;

class ProductFilter extends ApiFilter
{
    // Define filter properties and methods here
    protected $safeParams = [
        'name' => ['eq', 'like'],
        'price' => ['eq', 'lt', 'gt', 'lte', 'gte'],
        'subfamilyId' => ['eq'],
    ];

    protected $columnMap = [
        'subfamily' => 'subfamilyId',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'gt' => '>',
        'lte' => '<=',
        'gte' => '>=',
        'like' => 'like',
    ];


}
