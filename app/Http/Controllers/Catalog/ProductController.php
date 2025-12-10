<?php

namespace App\Http\Controllers\Catalog;

use App\Filters\QueryFilter;
use App\Filters\QueryFilter\ProductFilter;
use App\Http\Controllers\Controller;
use App\Repositories\Catalog\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(ProductFilter $filter, Request $request)
    {
        // If slug is present, return catalog
        if ($request->has('slug')) {
            return $this->productRepository->catalog($request->query('slug'));
        }

        // DEFAULT: Apply filters
        return $this->productRepository->filters($filter,$request);
    }

    public function getOnSaleProducts()
    {
        return $this->productRepository->getOnSaleProducts();
    }

    public function getLatestProducts()
    {
        return $this->productRepository->getLatestProducts();
    }

    public function show($product)
    {
        return $this->productRepository->find($product);
    }
}
