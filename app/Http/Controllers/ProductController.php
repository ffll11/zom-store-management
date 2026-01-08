<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class ProductController extends Controller
{
    protected $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function index()
    {
        Log::info('ProductController index called');
        return $this->productRepository->getProducts();
    }

    public function filteredProducts(Request $request)
    {
        Log::info('ProductController filteredProducts called with request: ', $request->all());
        return $this->productRepository->filteredProducts($request);
    }
    public function store(StoreProductRequest $request)
    {
        return $this->productRepository->create($request->validated());
    }
    public function show( $id)
    {
        return $this->productRepository->find($id);
    }
    public function update(UpdateProductRequest $request, $id)
    {
        return $this->productRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->productRepository->delete($id);
    }

    public function activePromotions($request)
    {
        return $this->productRepository->activePromotions($request);
    }
}
