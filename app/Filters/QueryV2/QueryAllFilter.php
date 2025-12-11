<?php

namespace App\Filters\QueryV2;

use Illuminate\Http\Request;

class QueryAllFilter
{
    protected $builder;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function filter($arr)
    {

        foreach ($arr as $key => $value) {

            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->builder;

    }

    protected function searchIn($fields, $searchTerm)
    {
        $searchParam = $this->request->query(key: 'search');
        if (! $searchParam) {
            return $this->builder;
        }

        return $this->builder->where(function ($query) use ($fields, $searchTerm) {
            foreach ($fields as $field) {
                $query->orWhere($field, 'LIKE', '%'.$searchTerm.'%');
            }
        });
    }

    protected function sort()
    {
        $sortParam = $this->request->query('orderBy');

        if ($sortParam) {
            $sortFields = explode(',', $sortParam);

            foreach ($sortFields as $field) {
                $direction = 'asc';

                if (str_starts_with($field, '-')) {
                    $direction = 'desc';
                    $field = ltrim($field, '-');
                }

                $this->builder->orderBy($field, $direction);
            }
        }

        return $this->builder;
    }

    public function apply($builder)
    {

        $this->builder = $builder;

        foreach ($this->request->all() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->builder;
    }
}
