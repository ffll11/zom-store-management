<?php

namespace App\Filters;

class CategoryFilter extends ApiFilter {

    protected $safeParams = [
        'name' => ['eq', 'like'],
    ];

    protected $columnMap = [
        'name' => 'name',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'like' => 'like',
    ];

}
