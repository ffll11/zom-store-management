<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Log;

class ProductController extends Controller
{
    protected $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function index(Request $request)
    {
        Log::info('ProductController index called with request: ', $request->all());
        return $this->productRepository->all($request);
    }
    public function store(StoreProductRequest $request)
    {
        return $this->productRepository->create($request->validated());
    }
    public function show(Product $product)
    {
        return $this->productRepository->find($product->id);
    }
    public function update(UpdateProductRequest $request, Product $product)
    {
        return $this->productRepository->update($product->id, $request->validated());
    }

    public function destroy(Product $product)
    {
        return $this->productRepository->delete($product->id);
    }
}
