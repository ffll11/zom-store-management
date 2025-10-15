<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Repositories\BrandRepository;

class BrandController extends Controller
{
    private $brandRepository;
    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }
    public function index()
    {
        return $this->brandRepository->all();
    }

    public function store(StoreBrandRequest $request)
    {
        return $this->brandRepository->create($request->validated());
    }

    public function show(Brand $brand)
    {
        return $this->brandRepository->find($brand->id);
    }

    public function update(UpdateBrandRequest $request, $id)
    {
        return $this->brandRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->brandRepository->delete($id);
    }
}
