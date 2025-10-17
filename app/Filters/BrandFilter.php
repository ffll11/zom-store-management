<?php

namespace App\Filters;

class BrandFilter extends ApiFilter {

    protected $safeParams = [
        'name' => ['eq', 'like'],
        'country' => ['eq', 'like'],
    ];

    protected $columnMap = [
        'country' => 'country',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'like' => 'like',
    ];


}
