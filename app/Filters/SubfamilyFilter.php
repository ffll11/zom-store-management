<?php

namespace App\Filters;

class SubfamilyFilter extends ApiFilter {

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
