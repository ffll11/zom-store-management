<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Repositories\BrandRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    private $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;

        $this->authorizeResource(Brand::class, 'brand');
    }

    public function index(Request $request)
    {
        return $this->brandRepository->all($request);
    }

    public function getBrandNames()
    {
        Log::info('Fetching brand names');

        return $this->brandRepository->getNameBrand();

    }

    public function getCountry()
    {
        Log::info('Fetching brand countries');

        return $this->brandRepository->getCountries();
    }

    public function store(StoreBrandRequest $request)
    {
        Log::info('Storing new brand with data: '.json_encode($request->validated()));

        return $this->brandRepository->create($request->validated());
    }

    public function show($id)
    {
        return $this->brandRepository->find($id);
    }

    public function update(UpdateBrandRequest $request, Brand $brand)
    {

        try{

        $brand = $this->brandRepository->update($brand->id, $request->validated());

        return new BrandResource($brand);

        } catch (ModelNotFoundException $e) {

            Log::error('Error updating brand with id '.$brand->id.': '.$e->getMessage());

            return response()->json(['error' => 'Failed to update brand'], 500);
        }
    }

    public function destroy(int $id)
    {
        // Use gate and policy

        return $this->brandRepository->delete($id);
    }
}
