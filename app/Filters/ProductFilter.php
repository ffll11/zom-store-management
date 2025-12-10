<?php

namespace App\Filters;

class ProductFilter extends ApiFilter
{
    protected $safeParams = [
        'name' => ['eq', 'like'],
        'price' => ['eq', 'lt', 'gt', 'lte', 'gte'],
        'salePrice' => ['eq', 'lt', 'gt', 'lte', 'gte'],
        'subfamilyId' => ['eq','in'],
        'brandId' => ['eq','in'],
        'price_asc' => ['asc'],
        'price_desc' => ['desc'],
        'name_asc' => ['asc'],
        'name_desc' => ['desc'],

        'familyId' => ['eq'],
        'subcategoryId' => ['eq'],
        'categoryId' => ['eq'],
        'description' => ['like'],

    ];

    protected $columnMap = [
        'subfamilyId' => 'subfamily_id',
        'brandId' => 'brand_id',
        'price_asc' => 'price',
        'price_desc' => 'price',
        'name_asc' => 'name',
        'name_desc' => 'name',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'gt' => '>',
        'lte' => '<=',
        'gte' => '>=',
        'like' => 'like',
        'asc' => 'asc',
        'desc' => 'desc',
        'in' => 'in',
    ];
}
