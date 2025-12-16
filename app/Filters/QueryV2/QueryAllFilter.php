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

    /**
     * Searches across multiple fields for a given search term.
     *
     * This method retrieves the search query parameter from the request and applies
     * a WHERE clause to the query builder that matches the search term across the
     * specified fields using LIKE operators.
     *
     * @param  array  $fields  The database fields to search across
     * @param  string|array  $searchTerm  The search term(s) to look for. Can be a string or array of strings
     * @return \Illuminate\Database\Eloquent\Builder|mixed The query builder instance with search conditions applied,
     *                                                     or the original builder if no search parameter is provided
     */
    protected function searchIn($fields, $searchTerm)
    {
        $searchParam = $this->request->query(key: 'search');
        if (! $searchParam) {
            return $this->builder;
        }

        return $this->builder->where(function ($query) use ($fields, $searchTerm) {
            foreach ($fields as $field) {

                $search = \is_array($searchTerm) ? implode(' ', $searchTerm) : $searchTerm;
                $words = preg_split('/\s+/', trim($search));
                $query->where(function ($q) use ($field, $words) {
                    foreach (array_filter($words) as $word) {
                        $q->orWhere($field, 'name', 'like', "%{$word}%");
                    }
                });
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

        foreach ($this->request->query() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->builder;
    }
}
