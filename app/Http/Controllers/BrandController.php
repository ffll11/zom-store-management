<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Repositories\BrandRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    private $brandRepository;
    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }
    public function index(Request $request)
    {
        return $this->brandRepository->all($request);
    }

    public function store(StoreBrandRequest $request)
    {
        Log::info("Storing new brand with data: " . json_encode($request->validated()));
        return $this->brandRepository->create($request->validated());
    }

    public function show($id)
    {
       return $this->brandRepository->find($id);
    }

    public function update(UpdateBrandRequest $request, $id)
    {
        $changedData = collect($request->validated())->filter()->all();
        Log::info("Updating brand ID: " . $id . " with data: " . json_encode($changedData));
        return $this->brandRepository->update($id, $changedData);
    }

    public function destroy($id)
    {
        return $this->brandRepository->delete($id);
    }
}
