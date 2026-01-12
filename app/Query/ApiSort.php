<?php

namespace App\Query;

use Illuminate\Http\Request;

class ApiSort
{
    protected array $allowedSorts = [];

    protected array $columnMap = [];

    public function __construct(array $allowedSorts = [], array $columnMap = [])
    {
        $this->allowedSorts = $allowedSorts;
        $this->columnMap = $columnMap;
    }

    public function apply(Request $request, $query)
    {
        $sort = $request->query('sort');
        if (! $sort || ! in_array($sort, $this->allowedSorts)) {
            return $query;
        }
        // split sort into column and direction
        [$field,$direction] = explode('_', $sort);

        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

        $column = $this->columnMap[$field] ?? $field;

        return $query->orderBy($column, $direction);
    }
}
