<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use App\Repositories\BrandRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    private $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
        //  $this->authorizeResource(Brand::class, 'brand');
    }

    public function index(Request $request)
    {
        return $this->brandRepository->all($request);
    }

    public function getBrandNames()
    {
        Log::info('Fetching brand names');

        return $this->brandRepository->getNameBrand();

        // return get name as a json response
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

    public function update(UpdateBrandRequest $request, $id)
    {
        $changedData = collect($request->validated())->filter()->all();
        Log::info('Updating brand ID: '.$id.' with data: '.json_encode($changedData));

        return $this->brandRepository->update($id, $changedData);
    }

    public function destroy($id)
    {
        // Use gate and policy

        return $this->brandRepository->delete($id);
    }
}
