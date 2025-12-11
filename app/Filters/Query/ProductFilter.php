<?php
namespace App\Filters\Query;

use Illuminate\Http\Request;

class ProductFilter extends QueryFilter {
    // You can add specific filter methods here if needed
        public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function brand($brandIds)
    {
          $ids = explode(',', $brandIds);
        return $this->builder->whereIn('brand_id', $ids);
    }

    public function subfamily($subfamilyIds)
    {
        $ids = explode(',', $subfamilyIds);
        return $this->builder->whereIn('subfamily_id', $ids);
    }

}
