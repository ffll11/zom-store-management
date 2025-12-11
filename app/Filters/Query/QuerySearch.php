<?php

namespace App\Filters\Query;
use Illuminate\Http\Request;
class QuerySearch
{
    protected $builder;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function search()
    {
        $searchTerm = $this->request->query('search');

        if ($searchTerm) {
            $this->builder->where(function ($query) use ($searchTerm) {
                $model = $this->builder->getModel();
                $searchableFields = property_exists($model, 'searchable') ? $model->searchable : [];

                foreach ($searchableFields as $field) {
                    $query->orWhere($field, 'like', '%' . $searchTerm . '%');
                }
            });
        }

        return $this->builder;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        return $this->search();
    }
}