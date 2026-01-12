<?php

namespace App\Query;

use Illuminate\Http\Request;

class ApiSearch
{
    protected array $searchableFields = [];

    protected array $columnMap = [];

    public function __construct(array $searchableFields = [], array $columnMap = [])
    {
        $this->searchableFields = $searchableFields;
        $this->columnMap = $columnMap;
    }

    public function apply(Request $request, $query)
    {
        $searchTerm = $request->query('search');

        if (! isset($searchTerm)) {
            return;
        }

        $query->where(function ($q) use ($searchTerm) {
            foreach ($this->searchableFields as $field) {
                $column = $this->columnMap[$field] ?? $field;
                $q->orWhere($column, 'LIKE', '%'.$searchTerm.'%');
            }
        });

        return $query;
    }
}
