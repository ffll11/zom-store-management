<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubcategoryResource;
use App\Models\Subcategory;
use App\Http\Requests\StoreSubcategoryRequest;
use App\Http\Requests\UpdateSubcategoryRequest;
use App\Repositories\SubcategoryRepository;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
   protected $subcategoryRepository;

   public function __construct(SubcategoryRepository $subcategoryRepository)
   {
       $this->subcategoryRepository = $subcategoryRepository;
   }
    public function index(Request $request)
    {
        return SubcategoryResource::collection($this->subcategoryRepository->all($request->query()));
    }

    public function store(StoreSubcategoryRequest $request)
    {
        $subcategory = $this->subcategoryRepository->create($request->validated());
        return new SubcategoryResource($subcategory);
    }
    public function show( $id)
    {
        $subcategory = $this->subcategoryRepository->find($id);
        return new SubcategoryResource($subcategory);
    }

    public function update(UpdateSubcategoryRequest $request, $id)
    {
        $subcategory = $this->subcategoryRepository->update($id, $request->validated());
        return new SubcategoryResource($subcategory);
    }

    public function destroy($id)
    {
        return $this->subcategoryRepository->delete($id);
    }
}
