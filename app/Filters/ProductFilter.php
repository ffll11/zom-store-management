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
    ];

    protected $columnMap = [
        'subfamily' => 'subfamilyId',
        'family' => 'familyId',
        'category' => 'categoryId',
        'subcategory' => 'subcategoryId',
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
