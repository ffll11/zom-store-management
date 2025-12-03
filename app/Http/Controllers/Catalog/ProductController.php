<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Repositories\Catalog\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        // Call all the other where i filter data
        // Call navproducts method
        // call search and filters

        if ($request->has('ids')) {
            return $this->getNavProducts($request);
        }
        if ($request->has('search')) {
            return $this->search($request);
        }
        if ($request->has('filters')) {
            return $this->filters($request);
        }

    }

    public function getOnSaleProducts()
    {
        return $this->productRepository->getOnSaleProducts();
    }

    public function getLatestProducts()
    {
        return $this->productRepository->getLatestProducts();
    }

    public function getNavProducts(Request $request)
    {
        $ids = $request->input('ids', []);

        return $this->productRepository->getNavProducts($ids);
    }

    public function search(Request $request)
    {
        $term = $request->query();

        return $this->productRepository->search($term);
    }

    public function filters(Request $request)
    {
        $filters = $request->query();

        return $this->productRepository->filters($filters);
    }

    public function show($slug)
    {
        return $this->productRepository->find($slug);
    }

}
