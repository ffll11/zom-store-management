<?php
namespace App\Filters\QueryV2;

class MenuAllFilter extends QueryAllFilter
{
    // Where has the brand id in array
    public function brand($brandIds)
    {
        $ids = explode(',', $brandIds);

        return $this->builder->whereIn('brand_id', $ids);
    }
}
