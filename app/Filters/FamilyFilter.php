<?php

namespace App\Filters;

class FamilyFilter extends ApiFilter {
    
    protected $safeParanms = [
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
