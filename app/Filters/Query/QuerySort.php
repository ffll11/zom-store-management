<?php

namespace App\Filters\Query;

use Illuminate\Http\Request;

class QuerySort
{
    protected $builder;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function orderBy($value){

        if(str_contains($value,'_')){
            $part = explode('_',$value);
            $direction = array_pop($part); // last part is direction
            $field = implode('_',$part); // rest is field

            $direction = in_array(strtolower($direction), ['asc','desc']) ? $direction : 'asc';
            return $this->builder->orderBy($field, $direction);

        }
    }

 
    public function sort()
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

        //cHECK
        foreach($this->request->all() as $key => $value){
            if(method_exists($this,$key)){
                $this->$key($value);
            }
        }

        return $this->builder;
    }
}
