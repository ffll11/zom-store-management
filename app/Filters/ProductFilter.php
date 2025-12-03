<?php

namespace App\Filters;

class ProductFilter extends ApiFilter
{
    protected $safeParams = [
        'name' => ['eq', 'like'],
        'price' => ['eq', 'lt', 'gt', 'lte', 'gte'],
        'subfamilyId' => ['eq'],
        'familyId' => ['eq'],
        'subcategoryId' => ['eq'],
        'categoryId' => ['eq'],
        'brandId' => ['eq'],
        'sale_price' => ['eq', 'lt', 'gt', 'lte', 'gte'],
    ];

    protected $columnMap = [
        'subfamily' => 'subfamilyId',
        'family' => 'familyId',
        'category' => 'categoryId',
        'subcategory' => 'subcategoryId',
        'brand' => 'brandId',
        'sale_price' => 'sale_price',
        
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
